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
    $data->book = $db_handle->get_query("SELECT * FROM ".get_env('TABLE_LINKS')." WHERE id = ?",[decode($encrypted_id)],true);
    
    $data->book = new Book($db_handle, $data->book);
    $data->book->relateds           = $data->book->relateds();
    $data->book->related_keywords   = $data->book->related_keywords();

    $cache->set($data);
}

$og = setMetas($messages, 'detail_', ['title' => $data->book->title, 'description' => $data->book->description]);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $og->detail_title ?></title>
        <meta name="og:description" content="<?= $og->detail_description ?>"/>
        <meta name="og:keywords" content="<?= $og->detail_keywords ?>" />
        <meta name="description" content="<?= $og->detail_description ?>"/>
        <meta name="keywords" content="<?= $og->detail_keywords ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="/public/uploads/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-16x16.png" sizes="16x16">
        <link rel="canonical" href="<?="$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" />
        <link rel="stylesheet" href="/assets/css/common.scss/common.css" />
        <link rel="stylesheet" href="/assets/css/detail.scss/detail.css" />
  </head>
  <body>
    <header>
      <div class="centered-element">
        <a href="/"><?= $messages['logo_name'] ?></a>
        <form id="search">
            <input type="text" id="search_input" placeholder="<?= $messages['search'] ?>" value="<?= isset($data->search_text) ? $data->search_text : '' ?>" />
            <button><img data-src="/assets/img/search-icon.svg" alt="" /></button>
        </form>
      </div>
    </header>
    <div class="einvaterss-container centered-element">
      <div>
        <div class="einvaterss-boxes">
          <div class="einvaterss-iframe-description">
            <div class="einvaterss-iframe">
              <div>
                <iframe src=""></iframe>
              </div>
              
            </div>
          </div>
        </div>
        <div class="einvaterss-descriptions">
          <p><?= $data->book->description ?> </p>
          <span>
            <img data-src="/assets/img/book2.jpg" />
            <span
              data-link="<?= $data->book->url ?>"
              ><img src="/assets/img/view-svgrepo-com.svg"
            /></span>
          </span>
          <p><?= $data->book->description ?> </p>
        </div>
      </div>
      <div class="einvaterss-boxes">
        <div class="einvaterss-boxes-list">
         <?php foreach($data->book->relateds as $book): ?>
            <div data-link="<?= $book->path ?>">
              <span href="<?= $book->path ?>">
                <img data-src="/assets/img/book1.jpg" alt="" />
                <span
                  class="einvatersse-view"
                  data-frame="<?= $book->url ?>"
                  ><img src="/assets/img/view-svgrepo-com.svg"
                /></span>
                
              </span>
              <div>
                <a href="<?= $book->path ?>"><?= $book->title?></a>
                <p><?=$book->description ?></p>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
    <div class="einvatersse-book-pop">
      <div>
        <div>
          <span><img src="/assets/img/x.svg" /></span>
          <div>
            <iframe></iframe>
          </div>
        </div>
      </div>
    </div>
    <div class="einvatersse-book-spinn">
      <div>
        <span></span>
      </div>
    </div>
    <footer>
      <div class="centered-element">
        <div>
            <?= $messages['footer_menu'] ?>
        </div>
      </div>
      <div>
        <div class="centered-element">
          <p><?= $messages['copyright'] ?></p>
          <div>
            <a href="#"><img data-src="/assets/img/facebook.svg" alt="" /></a>
            <a href="#"><img data-src="/assets/img/twitter.svg" alt="" /></a>
          </div>
        </div>
      </div>
    </footer>
    <script src="/assets/js/common.js"></script>
    <script src="/assets/js/detail.js"></script>
  </body>
</html>
