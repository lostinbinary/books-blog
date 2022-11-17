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
<html>
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
            <button><img data-src="/assets/img/search-icon.svg" alt="" /></button>
        </form>
      </div>
    </header>
    <div class="weinnn-container centered-element">
      <div class="weinnn-boxes">
        <div class="weinnn-boxes-list">
          <?php foreach($data->books as $book): ?>
            <div data-link="<?= $book->path ?>">
              <span href="<?= $book->path ?>">
                <img data-src="/assets/img/book1.jpg" alt="" />
                <span
                  class="weinnne-view"
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
      <?php if(!isset($page)): ?>
      <div class="weinnne-content-section">
        <h1>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque,
          tempore?
        </h1>
        <div class="content-section-boxs">
          <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Numquam
            voluptatum tempore vitae eius, architecto dignissimos similique
            adipisci quibusdam? Quis, porro consequuntur illo aperiam velit
            expedita soluta ex aliquid iusto aut ad veniam. Asperiores totam
            tenetur nemo ipsa reprehenderit vero porro?
          </p>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod esse
            eum odit fuga magni repellendus sapiente ea alias mollitia corporis
            nam laboriosam explicabo voluptatem neque, laudantium eligendi
            officiis fugiat eaque quos blanditiis dolorum necessitatibus
            impedit. Repellat minima consequuntur quae eaque voluptates unde
            tempore. Ut sequi obcaecati accusamus quis eius maiores blanditiis
            delectus quisquam! Voluptatum sit quaerat ipsum temporibus quibusdam
            repellat?
          </p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam
            deleniti aliquam quibusdam provident tempora necessitatibus possimus
            vitae ratione aspernatur debitis.
          </p>
          <h4>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Consequatur, voluptate.
          </h4>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim,
            aspernatur assumenda iste obcaecati nulla et, incidunt vero corporis
            recusandae fugit necessitatibus! Placeat vel ut nobis voluptate
            laborum, nisi tempore veritatis debitis earum deleniti voluptatem
            eos corporis odit est culpa eveniet dolor blanditiis dolorum tenetur
            eius pariatur animi autem voluptas temporibus. Cumque fuga maxime
            totam, accusamus eaque odio similique quos nostrum corporis
            obcaecati alias rem perspiciatis unde ut, aspernatur asperiores
            aperiam!
          </p>
          <ul>
            <li>test 1 list</li>
            <li>test 2 list</li>
            <li>test 3 list</li>
            <li>test 4 list</li>
          </ul>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur,
            totam.<strong>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Excepturi, pariatur.</strong
            >
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odio
            doloribus magni corrupti ex commodi blanditiis, eligendi at aperiam
            qui consequuntur.
          </p>
          <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus
            id dicta dolore, vitae illum inventore. Repellat error molestiae
            magnam soluta quo quisquam iusto, aliquid quos, iste distinctio
            tempora, culpa consequatur sint enim! Quis, dolores ad. Repellat,
            numquam sit. Libero, facilis dicta accusantium explicabo natus
            incidunt temporibus ipsum illo necessitatibus numquam.
          </p>
          <img data-src="/assets/img/images_photos.jpg" />
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto
            repellendus, reprehenderit fugit consequuntur commodi aut. Dolores
            adipisci ipsum tempore soluta. Sit quas sapiente odio obcaecati
            nulla aliquid reprehenderit repellendus, corporis quasi molestiae
            iste veniam tempora dolore numquam, nostrum at quaerat iusto! Nulla
            natus cum, ullam reprehenderit eaque ipsam similique excepturi?
          </p>
        </div>
      </div>
      <?php endif ?>
    </div>
    <div class="weinnne-book-pop">
      <div>
        <div>
          <span><img src="/assets/img/x.svg" /></span>
          <div>
            <iframe></iframe>
          </div>
        </div>
      </div>
    </div>
    <div class="weinnne-book-spinn">
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
  </body>
</html>
