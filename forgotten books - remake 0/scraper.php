<?php define('HEADER_SECURITY', true);

include 'inc/messages.php';
include 'inc/connect.php';
// include 'inc/modules/book.php';

$SQL = "SELECT * FROM " . GET_ENV("TABLE_LINKS") . " WHERE checked = false LIMIT 10";
$rows = $db_handle->get_query($SQL);
foreach($rows as $row) {
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
    
    $SQL = "UPDATE " . GET_ENV("TABLE_LINKS") . " SET checked = true, ask_data = '$data' WHERE id = '$row->id'";
    $db_handle->update_query($SQL);
}