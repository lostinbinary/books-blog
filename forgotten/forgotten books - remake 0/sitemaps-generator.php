<?php 
ini_set('memory_limit', '-1');

define('HEADER_SECURITY', true);

include 'inc/messages.php';
include 'inc/connect.php';

$TABLE_LINKS    = get_env('TABLE_LINKS');
$TABLE_KEYWORDS = get_env('TABLE_KEYWORDS');
$LIMIT          = '10';

$URL            = "https://$_SERVER[HTTP_HOST]";


// get sitemap page
if(!is_dir('sitemaps'))
    mkdir("sitemaps", 0777, true);
$sitemaps = scandir("sitemaps");
$sitemaps_count = 0;


// -----
$sitemaps_count = 0;
foreach($sitemaps as $sitemap_file)
    if(strpos($sitemap_file,'sitemap-books-') !== false) 
        $sitemaps_count++;

$sitemaps_offset = ($sitemaps_count) * $LIMIT;

// get data for sitemap
$rows = $db->query("SELECT * FROM $TABLE_LINKS LIMIT $sitemaps_offset, $LIMIT")->fetchAll(PDO::FETCH_OBJ);

// generate sitemap input
$sitemaps_input = '<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

foreach($rows as $row)
    $sitemaps_input .= '<url>
        <loc>'.$URL.'/detail/'.base_convert($row->id, 15, 32).'/'.slug($row->title).'</loc>
        <priority>0.'.rand(1,9).'</priority>
    </url>';

$sitemaps_input .= '</urlset>';

// create sitemap
if(count($rows) > 0) {
    $myfile = fopen("sitemaps/sitemap-books-$sitemaps_count.xml", "w") or die("Unable to open file!");
    fwrite($myfile, $sitemaps_input);
    fclose($myfile);
}


// -----
$sitemaps_count = 0;
foreach($sitemaps as $sitemap_file)
    if(strpos($sitemap_file,'sitemap-keywords-') !== false) 
        $sitemaps_count++;

$sitemaps_offset = ($sitemaps_count) * $LIMIT;

// get data for sitemap
$rows = $db->query("SELECT * FROM $TABLE_KEYWORDS LIMIT $sitemaps_offset, $LIMIT")->fetchAll(PDO::FETCH_OBJ);

// generate sitemap input
$sitemaps_input = '<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

foreach($rows as $row)
    $sitemaps_input .= '<url>
        <loc>'.$URL.'/s/'.slug($row->keyword).'</loc>
        <priority>0.'.rand(1,9).'</priority>
    </url>';

$sitemaps_input .= '</urlset>';

// create sitemap
if(count($rows) > 0) {
    $myfile = fopen("sitemaps/sitemap-keywords-$sitemaps_count.xml", "w") or die("Unable to open file!");
    fwrite($myfile, $sitemaps_input);
    fclose($myfile);
}


// -----
$sitemaps = scandir("sitemaps");
$sitemaps_input = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach($sitemaps as $sitemap_file)
    if(strpos($sitemap_file,'sitemap-') !== false) 
        $sitemaps_input .= '<sitemap>
            <loc>'.$URL.'/sitemaps/'.$sitemap_file.'</loc>
        </sitemap>';

$sitemaps_input .= '</sitemapindex>';

// create sitemap
$myfile = fopen("sitemaps/sitemaps.xml", "w") or die("Unable to open file!");
fwrite($myfile, $sitemaps_input);
fclose($myfile);