<?php if(defined('HEADER_SECURITY') != true) die();

include 'inc/messages.php';
include 'inc/connect.php';
include 'inc/cache.php';
include 'inc/modules/book.php';

$data = new Stdclass;
$data->search_text = '';
$data->pagination = new Pagination;
	
if ($cache->isCached()) {
	$data = $cache->getCache();
    // echo "<pre>"; print_r($data);
} else {
    $data->pagination->setLimit(get_env('MAIN_LIMIT'));
    if(isset($page) && !empty($page))
        $data->pagination->setPage( intVal($page) );

    $data->search_text = str_replace('-', ' ', urldecode($search_text));
    
    $WHERE = "WHERE MATCH(title) AGAINST(?)";
    // get books
    $data->books = $db_handle->get_query("SELECT * FROM ".get_env('TABLE_LINKS')." 
        $WHERE
        ORDER BY id DESC 
        LIMIT {$data->pagination->offset}, {$data->pagination->limit}",[$data->search_text]);
        
    foreach($data->books as &$book)
        $book = new Book($db_handle, $book);
    
    // pagination end
    $total = $db_handle->get_query("SELECT COUNT(*) as total FROM ".get_env('TABLE_LINKS')." $WHERE", [$data->search_text], true)->total;
    $data->pagination->update($total);

    $data->related_keywords = $db_handle->get_query("SELECT * FROM ".get_env('TABLE_KEYWORDS')." WHERE MATCH(keyword) AGAINST (?) LIMIT 20",[$data->search_text]);
    
    $cache->set($data);

}
set_metas('search','{search_text}',$data->search_text,$messages);
if($data->pagination->page > 1) set_metas('search','{page}',$data->pagination->page,$messages);
else set_metas('search','{page}','',$messages);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $messages['search_title'] . (isset($page)?" - $messages[page] $page":'') ?></title>
        <meta name="og:description" content="<?= $messages['search_description'] ?>"/>
        <meta name="og:keywords" content="<?= $messages['search_keywords'] ?>" />
        <meta name="description" content="<?= $messages['search_description'] ?>"/>
        <meta name="keywords" content="<?= $messages['search_keywords'] ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="/public/uploads/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-16x16.png" sizes="16x16">
        <link rel="canonical" href="<?="$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" />
        <link rel="stylesheet" href="/assets/css/common.scss/common.css" />
        <style>
            .pagination{display:flex;justify-content:center;margin:20px 0}.pagination>ul{display:flex;align-items:center;flex-wrap:wrap}.pagination>ul li{margin:5px;list-style-type: none}.pagination>ul li a{display:inline-flex;justify-content:center;align-items:center;padding:10px 20px;background-color:#fff;border:1px solid #606060;font-size:1.2rem;color:#606060;cursor:pointer}.pagination>ul li .active_pag{background-color:rgba(0,0,0,.1)}
        </style>
    </head>
  <body>
    <header>
      <div class="centered-element">
        <a href="/"><?= $messages['logo_name'] ?></a>
        <form id="search">
          <input type="text" id="search_input" placeholder="<?= $messages['search'] ?>" value="<?= isset($data->search_text) ? $data->search_text : '' ?>" />
          <button><img data-src="/assets/img/search-icon.svg" /></button>
        </form>
      </div>
    </header>
    <div class="investeddd-map centered-element">
      
    </div>
    <div class="investeddd-container centered-element">
      <div class="investeddd-boxes">
        <div class="investeddd-boxes-list">
          
          <h1><?= $messages['search_h1'] ?></h1>
          <?php foreach($data->books as $book): ?>
            <div data-link="<?= $book->path ?>">
              <a href="<?= $book->path ?>"><img data-src="/assets/img/book1.jpg" alt="" /></a>
              <div>
                <a href="<?= $book->path ?>"><?= $book->title ?></a>
                
                <p><?=$book->description ?></p>
              </div>
            </div>
          <?php endforeach ?>
        </div>
            <div style="padding: 5px">
                <?php require_once('layouts/pagination.php'); ?>
            </div>
      </div>
      <div class="investeddd-search">
        <div>
                    <div>                
            <?php foreach($data->related_keywords as $related_keyword): ?>
                <a href="/s/<?= slug($related_keyword->keyword) ?>"><?= $related_keyword->keyword ?></a>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="centered-element">
        <div class="investeddd-footer-logo">
          <a href="/"><?= $messages['logo_name'] ?></a>
          <div>
            <ul>
              <li><a href="#">For Librarians</a></li>
              <li><a href="#">For Publishers</a></li>
              <li><a href="#">For Researchers</a></li>
              <li><a href="#">Funders</a></li>
              <li><a href="#">Resources</a></li>
              <li><a href="#">OAPEN</a></li>
            </ul>
          </div>
          <span>©2020 OAPEN</span>
        </div>
      </div>
    </footer>
    <script src="/assets/js/common.js"></script>
  </body>
</html>
