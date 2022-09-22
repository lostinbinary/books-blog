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
    if(isset($page) && !empty($page))
        $data->pagination->setPage( intVal($page) );

    // get books
    $books = $db_handle->get_query("SELECT * FROM israelpdf1_db 
        ORDER BY id DESC 
        LIMIT {$data->pagination->offset}, {$data->pagination->limit}");
        
    foreach($books as &$book)
        $book = new Book($db_handle, $book);

    // pagination end
    $total = $db_handle->get_query("SELECT COUNT(*) as total FROM israelpdf1_db", [], true)->total;
    $data->pagination->update($total);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= $messages['index_title'] . (isset($page)?" - $messages[page] $page":'') ?></title>
        <meta name="og:description" content="<?= $messages['index_description'] ?>"/>
        <meta name="og:keywords" content="<?= $messages['index_keywords'] ?>" />
        <meta name="description" content="<?= $messages['index_description'] ?>"/>
        <meta name="keywords" content="<?= $messages['index_keywords'] ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="/public/uploads/apple-icon-180x180.png">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-16x16.png" sizes="16x16">
        <link rel="canonical" href="<?="$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" />
        <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu:700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/common.scss/common.css" />
        <style>
            .pagination{display:flex;justify-content:center;margin:20px 0}.pagination>ul{display:flex;align-items:center;flex-wrap:wrap}.pagination>ul li{margin:5px;list-style-type: none}.pagination>ul li a{display:inline-flex;justify-content:center;align-items:center;padding:10px 20px;background-color:#fff;border:1px solid #606060;font-size:1.2rem;color:#606060;cursor:pointer}.pagination>ul li .active_pag{background-color:rgba(0,0,0,.1)}
        </style>
    </head>
    <body>

        <?php require_once('layouts/header.php'); ?>

        <div class="forgottenn-centered-text">
        <?= preg_replace('/{count}/i', number_format($data->pagination->rows_count), $messages['index_p']) ?>
        </div>
        <div class="forgottenn-container">
            <div>
                <div class="forgottenn-books-list">
                    <?php foreach($books as $book): ?>
                        <a href="<?= $book->path() ?>">
                            <div>
                            <div><?= $book->title?></div>
                            <p><?= $book->description ?></p>
                            </div>
                            <img data-src="/assets/img/1.jpg" />
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
            <div style="padding: 5px">
                <?php require_once('layouts/pagination.php'); ?>
            </div>

            <?php if(!isset($page)): ?>
            <?= $messages['main_footer_text'] ?>
            <?php endif ?>

        </div>

        <?= $messages['footer'] ?>
        <script src="/assets/js/common.js"></script>
    </body>
</html>