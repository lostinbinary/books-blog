<?php if(defined('HEADER_SECURITY') != true) die();

/*
ini_set('memory_limit', '-1');
ini_set('display_errors', 'on');
error_reporting(E_ALL);
*/

$messages = [
    'logo_name' => 'Unlimited Content',
    'search' => 'Search...',
    'footer' => '<footer>
        <div>
            <p>
            Forgotten Books is a registered trademark of FB &c Ltd. Copyright ©
            2016 FB &c Ltd. <br />
            FB &c Ltd, Dalton House, 60 Windsor Avenue, London, SW19 2RR. Company
            number 08720141. Registered in England and Wales.
            </p>
            <div><a href="#">Terms of Use</a> | <a>Privacy Policy</a></div>
        </div>
        </footer>',

    'index_title' => 'UCM',
    'index_description' => 'UCM',
    'index_keywords' => 'UCM',
    'index_p' => '<p>
            Forgotten Books is a London-based book publisher specializing in the
            restoration of old books, both fiction and non-fiction.
        </p>
        <p>
            Today we have <strong>{count}</strong> books available to read online,
            download as ebooks, or purchase in print.
        </p>',

    'search_title' => 'Search result: {search_text}{page}',
    'search_description' => 'Search result: {search_text}{page}',
    'search_keywords' => 'Search result: {search_text}{page}',
    'search_h1' => 'Search result: {search_text}{page}',
    
    'main_footer_text' => '<div class="forgottenn-content-section">
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
        </div>',

    'detail_title' => '{title}',
    'detail_description' => '{description}',
    'detail_keywords' => '{title} {description}',
    
    'download' => 'download',
	'related' => 'related books',
    'related_keywords' => 'related keywords',

	'page' => 'page',
    'no_data' => '- No Data -',
    'next' => 'Next',
    'previous' => 'Previous',
];

class Pagination
{
    public $page = 1;
    public $limit = 12;
    public $offset = 1;
    public $last_page = 1;
    public $rows_count = 0;

    function __construct() {
        $this->setPage(1);
        $this->updateVars();
    }
    function setLimit($limit) {
        $this->limit = $limit;
        $this->updateVars();
    }
    function setPage($page) {
        $this->page = $page;
        $this->updateVars();
    }
    function update($count) {
        $this->rows_count = $count;
        $this->updateVars();
    }
    function updateVars() {
        $this->offset = ($this->page - 1) * $this->limit;
        $this->last_page = intVal($this->rows_count / $this->limit);
        if($this->rows_count % $this->limit)
            $this->last_page += 1;
    }
}

function setMetas(&$messages, $index, $data)
{
    $meta_keys = ['title','description','keywords'];
    $meta_data = new stdClass;
    foreach($meta_keys as $key) {
        $meta_data->{$index.$key} = $messages[$index.$key];
        foreach($data as $data_key => $data_value)
            $meta_data->{$index.$key} = str_replace('{'.$data_key.'}', $data_value, $meta_data->{$index.$key});
    }
    $meta_data->{$index.'keywords'} = slug($meta_data->{$index.'keywords'},',');
    return $meta_data;
}

function encode($id)
{
    return base_convert($id, 15, 32);
}

function decode($id)
{
    return base_convert($id, 32, 15);
}

function slug($string, $slug = '-')
{
    $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $string);
    $string = preg_replace('/\s+/u', $slug, $string);
    return strtolower($string);
}

function set_metas($page,$key,$value,&$messages)
{
    foreach(['title','description','keywords','h1'] as $meta)
        $messages[$page.'_'.$meta] = str_replace($key, $value, $messages[$page.'_'.$meta]);
    $messages[$page.'_keywords'] = slug($messages[$page.'_keywords'], ',');
}

function uploadImage($key, $filename = false)
{
    if(isset($_FILES[ $key ]) && strlen($_FILES[ $key ]['name']) > 1)
    {
        $uploadedFileName = round(microtime(true));
        if($filename) $uploadedFileName = $filename;

        $targetfolder = "public/uploads/";

        $temp = explode(".", $_FILES[ $key ]["name"]);
        $extension = strtolower( end($temp) );
        $newfilename = "$uploadedFileName.$extension";
        
        $MB = 10 * 100000;
        if($_FILES[ $key ]['type'] != "image/jpg" && $_FILES[ $key ]['type'] != "image/png" && $_FILES[ $key ]['type'] != "image/jpeg") {
            echo "File is not a image!"; exit; }
        if ($_FILES[ $key ]["size"] > 50*$MB ) { echo "File is more than 50MB!"; exit; }

        $targetfilepath = $targetfolder . $newfilename;
        if(move_uploaded_file($_FILES[ $key ]['tmp_name'], "$targetfilepath")) {}

        return "/$targetfilepath";
    }
    return false;
}

function get_env($index)
{
    if (!is_readable('.env')) {
        throw new \RuntimeException(sprintf('%s file is not readable', '.env'));
    }

    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {

        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if($name == $index) return $value;
    }
    return false;
}
// echo get_env('APP_ENV'); die();

$_SERVER['REQUEST_SCHEME'] = 'http';