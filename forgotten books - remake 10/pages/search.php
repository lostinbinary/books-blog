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
        <link rel="apple-touch-icon" sizes="180x180" href="/public/uploads/apple-icon-180x180.png">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/public/uploads/favicon-16x16.png" sizes="16x16">
        <link rel="canonical" href="<?="$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" />
        <link rel="stylesheet" href="/assets/css/common.scss/common.css" />
        <link rel="stylesheet" href="/assets/css/detail.scss/detail.css" />
        <style>
            .pagination{display:flex;justify-content:center;margin:20px 0}.pagination>ul{display:flex;align-items:center;flex-wrap:wrap}.pagination>ul li{margin:5px;list-style-type: none}.pagination>ul li a{display:inline-flex;justify-content:center;align-items:center;padding:10px 20px;background-color:#fff;border:1px solid #606060;font-size:1.2rem;color:#606060;cursor:pointer}.pagination>ul li .active_pag{background-color:rgba(0,0,0,.1)}
        </style>
    </head>
  <body>
    <header>
      <div>
        <!-- <div class="stoppeddd-map">
          <a href="#">Forgotten Books</a>
        </div> -->
        <a href="/"><?= $messages['logo_name'] ?></a>
        <form id="search">
            <input type="text" id="search_input" placeholder="<?= $messages['search'] ?>" value="<?= $data->search_text ?? '' ?>" />
            <button><img data-src="/assets/img/search-icon.svg" alt="" /></button>
        </form>
      </div>
    </header>
    <div class="stoppeddd-centered-text">
        <?= preg_replace('/{count}/i', number_format($data->pagination->rows_count), $messages['index_p']) 
            . (isset($page)?" - $messages[page] $page":'') ?>
    </div>
    <div class="stoppeddd-container">
      <div>
        <div class="stoppeddd-books-list">
          <div>                <?php foreach($data->related_keywords as $related_keyword): ?>
                    <a href="/s/<?= slug($related_keyword->keyword) ?>"><?= $related_keyword->keyword ?></a>
                <?php endforeach ?>
          </div>
          
                    <?php foreach($data->books as $book): ?>
                        <a href="<?= $book->path ?>">
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

            <div class="stoppeddd-keywords">
          <h2><?= $messages['related_keywords'] ?></h2>
          <div>
            <?php foreach($data->book->related_keywords as $related_keyword): ?>
                <a href="/s/<?= slug($related_keyword->keyword) ?>"><?= $related_keyword->keyword ?></a>
            <?php endforeach ?>
          </div>
        </div>

        </div>

        <?= $messages['footer'] ?>
        <script src="/assets/js/common.js"></script>
        <script src="/assets/js/detail.js"></script>
    </body>
</html>
