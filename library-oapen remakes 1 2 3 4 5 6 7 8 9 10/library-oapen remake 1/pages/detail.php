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
          <button><img data-src="/assets/img/search-icon.svg" /></button>
        </form>
      </div>
    </header>
    <div class="doubleswordd-map centered-element">
      
    </div>
    <div class="doubleswordd-container centered-element">
      <div class="doubleswordd-boxes">
        <h1><?= $data->book->title ?> </h1>
        <p><?= $data->book->description ?> </p>
        <div class="doubleswordd-iframe-description">
          <!-- <div class="doubleswordd-description">
            <div>
              <span>Author</span>
              <div>Farris, William</div>
            </div>
            <div>
              <span>Collection</span>
              <div>Knowledge Unlatched (KU)</div>
            </div>
            <div>
              <span>Number</span>
              <div>102951</div>
            </div>
            <div>
              <span>Author</span>
              <div>Farris, William</div>
            </div>
            <a href="#">Show full item record</a>
          </div> -->
          <div class="doubleswordd-iframe">
            <div>
              <iframe src=""></iframe>
              <div
                class="doubleswordd-iframe-btn"
                data-link="<?= $data->book->url ?>"
              >
                <div>
                  <img data-src="/assets/img/book1.jpg" alt="" />
                  <span
                    ><img data-src="/assets/img/view-svgrepo-com.svg" alt=""
                  /></span>
                </div>
              </div>
              <span class="doubleswordd-circles">
                <div>
                  <span></span>
                </div>
              </span>
            </div>
            
          </div>
        </div>
        <div class="doubleswordd-boxes-list">
          
          <?php foreach($data->book->relateds as $book): ?>
            <div data-link="<?= $book->path ?>">
              <a href="<?= $book->path ?>"><img data-src="/assets/img/book1.jpg" alt="" /></a>
              <div>
                <a href="<?= $book->path ?>"><?= $book->title ?></a>
                
                <p><?=$book->description ?></p>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
      <div class="doubleswordd-search">
        <div>
                    <span><?= $messages['related_keywords'] ?></span>
          <div>
            <?php foreach($data->book->related_keywords as $related_keyword): ?>
              <a href="/s/<?= slug($related_keyword->keyword) ?>"><?= $related_keyword->keyword ?></a>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="centered-element">
        <div class="doubleswordd-footer-logo">
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
    <script src="/assets/js/detail.js"></script>
  </body>
</html>
