<?php if(defined('HEADER_SECURITY') != true) die();

include 'inc/messages.php';
include 'inc/connect.php';
include 'inc/cache.php';
include 'inc/modules/book.php';

$data = new Stdclass;
	
if ($cache->isCached()) {
	$data = $cache->getCache();
} else {
    if(isset($page) && !empty($page))
        $data->pagination->setPage( intVal($page) );

    // get books
    $book = $db_handle->get_query("SELECT * FROM israelpdf1_db WHERE id = ?",[decode($encrypted_id)],true);
    $book = new Book($db_handle, $book);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= str_replace('{title}', $book->title, $messages['detail_title']) ?></title>
        <meta name="og:description" content="<?= str_replace('{description}', $book->description, $messages['detail_description']) ?>"/>
        <meta name="og:keywords" content="<?= str_replace('{description}', $book->description, $messages['detail_keywords']) ?>" />
        <meta name="description" content="<?= str_replace('{description}', $book->description, $messages['detail_description']) ?>"/>
        <meta name="keywords" content="<?= str_replace('{description}', $book->description, $messages['detail_keywords']) ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="/public/uploads/apple-icon-180x180.png">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-16x16.png" sizes="16x16">
        <link rel="canonical" href="<?="$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" />
        <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu:700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/common.scss/common.css" />
        <link rel="stylesheet" href="/assets/css/detail.scss/detail.css" />
  </head>
  <body>

    <?php require_once('layouts/header.php'); ?>

    <div class="forgottenn-container">
      <div>
        <div class="forgottenn-single">
          <div class="forgottenn-single-image">
            <span><img data-src="/assets/img/1.jpg" /></span>
            <div>
              <h1><?= $book->title ?></h1>
              <!-- <strong>by Lileen Hardy</strong> -->
              <button>
                <img data-src="/assets/img/pdf.png" />
                <span>download</span>
              </button>
            </div>
          </div>
          <div class="forgottenn-iframee">
            <div><img src="/assets/img/x.svg" alt="" /></div>
            <iframe
              data-src="<?= $book->url ?>"
            ></iframe>
          </div>
          <div class="forgottenn-single-text">
            <div>
              <span>Description</span>
              <p><?= $book->description ?> </p>
            </div>
        </div>
        <div class="forgottenn-books-list">

            <?php foreach($book->relateds() as $related_book): ?>
                <a href="<?= $related_book->path() ?>">
                    <div>
                    <div><?= $related_book->title?></div>
                    <p><?= $related_book->description ?></p>
                    </div>
                    <img data-src="/assets/img/1.jpg" />
                </a>
            <?php endforeach ?>
          
        </div>
        <div class="forgottenn-keywords">
          <h2>related links</h2>
          <div>
            <?php foreach($book->related_keywords() as $related_keyword): ?>
                <a href="/s/<?= slug($related_keyword->keyword) ?>"><?= $related_keyword->keyword ?></a>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
    <?= $messages['footer'] ?>
    <script src="/assets/js/common.js"></script>
    <script src="/assets/js/detail.js"></script>
  </body>
</html>
