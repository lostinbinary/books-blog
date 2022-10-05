<?php 

// Global Variables
$HOST           = 'localhost';
$DATABASE       = 't2';
$USER           = 'giorgi2021';
$PASSWORD       = 'giorgi2021';

$TABLE_LINKS    = 'israelpdf1_db';
$LIMIT          = '10';


// connection
$db = new PDO("mysql:host=$HOST;dbname=$DATABASE;charset=utf8", $USER, $PASSWORD) or die("Cannot connect to mySQL.");

$rows = $db->query("SELECT * FROM $TABLE_LINKS WHERE checked = false LIMIT $LIMIT")->fetchAll(PDO::FETCH_OBJ);

foreach($rows as $row)
{
    $title = str_replace(' ', '+', $row->title);
    $response = file_get_contents("https://www.ask.com/web?q=" . $title);
    
    $json = [];
    if(preg_match_all('~class="PartialSearchResults-item-wrapper">(.*?)</p>~is', $response, $match)) {
        foreach($match[0] as $block_html) {
            $block = new stdClass;
            if(preg_match('~a.*?noreferrer\' >(.*?)</a>~is', $block_html, $block_match))
                $block->title = $block_match[1];
            if(preg_match('~class="PartialSearchResults-item-abstract">(.*?)</p>~is', $block_html, $block_match))
                $block->description = $block_match[1];
            $json[] = $block;
        }
    }
    $data = json_encode($json);
    
    // update row
    $SQL = "UPDATE $TABLE_LINKS SET checked = true, ask_data = '$data' WHERE id = '$row->id'";
    $stmt = $db->prepare($SQL);
    $stmt->execute();
}




