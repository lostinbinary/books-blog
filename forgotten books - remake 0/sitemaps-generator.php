<?php 

// Global Variables
$HOST           = '127.0.0.1';
$DATABASE       = 'books-blog';
$USER           = 'root';
$PASSWORD       = '';

$TABLE_LINKS    = 'israelpdf1_db';
$LIMIT          = '10';


// connection
$db = new PDO("mysql:host=$HOST;dbname=$DATABASE;charset=utf8", $USER, $PASSWORD) or die("Cannot connect to mySQL.");


// get sitemap page
if(!is_dir('sitemaps'))
    mkdir("sitemaps", 0777, true);
$sitemaps = scandir("sitemaps");
$sitemaps_count = 0;

foreach($sitemaps as $sitemap_file)
    if(strpos($sitemap_file,'sitemap-') !== false) 
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
        <loc>/detail/'.base_convert($row->id, 15, 32).'/'.str_replace(' ','-',$row->title).'</loc>
        <lastmod>'.date('Y-m-d').'T'.date('H:i:s').'+00:00</lastmod>
        <priority>0.51</priority>
    </url>';

$sitemaps_input .= '</urlset>';


// create sitemap
$myfile = fopen("sitemaps/sitemap-$sitemaps_count.xml", "w") or die("Unable to open file!");
fwrite($myfile, $sitemaps_input);
fclose($myfile);

