<?php if(defined('HEADER_SECURITY') != true) die();

include 'inc/messages.php';
include 'inc/connect.php';
include 'inc/cache.php';
include 'inc/modules/book.php';

$data = new Stdclass;
$data->pagination = new Pagination;
	
if ($cache->isCached()) {
	$data = $cache->getCache();
} else {
    $data->pagination->setLimit(get_env('MAIN_LIMIT'));
    if(isset($page) && !empty($page))
        $data->pagination->setPage( intVal($page) );

    // get books
    $data->books = $db_handle->get_query("SELECT * FROM ".get_env('TABLE_LINKS')." 
        ORDER BY id DESC 
        LIMIT {$data->pagination->offset}, {$data->pagination->limit}");
        
    foreach($data->books as &$book)
        $book = new Book($db_handle, $book);

    // pagination end
    $total = $db_handle->get_query("SELECT COUNT(*) as total FROM ".get_env('TABLE_LINKS')."", [], true)->total;
    $data->pagination->update($total);

    $data->keywords = $db_handle->get_query("SELECT * FROM ".get_env('TABLE_KEYWORDS')." LIMIT {$data->pagination->offset}, {$data->pagination->limit}");


    $cache->set($data);
}
if($data->pagination->page > 1) set_metas('index','{page}',' '.$data->pagination->page,$messages);
else set_metas('index','{page}','',$messages);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $messages['index_title'] . (isset($page)?" - $messages[page] $page":'') ?></title>
        <meta name="og:description" content="<?= $messages['index_description'] ?>"/>
        <meta name="og:keywords" content="<?= $messages['index_keywords'] ?>" />
        <meta name="description" content="<?= $messages['index_description'] ?>"/>
        <meta name="keywords" content="<?= $messages['index_keywords'] ?>" />
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

    <div class="catch22-container centered-element">
      <div class="catch22-boxes">
        <div class="catch22-boxes-list">
          <h1><?= $messages['index_h1'] ?></h1>
          <?php foreach($data->books as $book): ?>
            <div data-link="<?= $book->path ?>">
                <a href="<?= $book->path ?>" class="catch22-title"><?= $book->title ?></a>

                <span
                class="catch22-view-book"
                data-pdf="<?= $book->url ?>"
                ><img data-src="/assets/img/view-svgrepo-com.svg"
                /></span>
                <a href="<?= $book->path ?>" class="catch22-img"
                ><img data-src="/assets/img/book2.jpg" alt=""
                /></a>
                <p><?=$book->description ?></p>
            </div>
        <?php endforeach ?>
        </div>
      </div>
      <div style="padding: 5px">
          <?php require_once('layouts/pagination.php'); ?>
      </div>
      <div class="catch22-relateds">
        
      </div>
    </div>
    <div class="catch22-book-pop">
      <div>
        <div>
          <span><img src="/assets/img/x.svg" /></span>
          <div>
            <iframe></iframe>
          </div>
        </div>
      </div>
    </div>
    <div class="catch22-book-spinn">
      <div>
        <span></span>
      </div>
    </div>
    <footer>
      <div class="centered-element">
        <p><?= $messages['footer'] ?></p>
      </div>
    </footer>
    <script src="/assets/js/common.js"></script>
  </body>
</html>
