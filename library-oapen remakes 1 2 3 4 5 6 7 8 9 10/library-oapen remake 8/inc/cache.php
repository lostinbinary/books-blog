<?php if(defined('HEADER_SECURITY') != true) die();

class Cache
{
    public $cacheName = '';
    public $cachetime = '60 minutes'; 
    public $caching = true;


    function __construct()
    {
        $this->cacheName = 'cache/'. md5($_SERVER['REQUEST_URI']) . '.json';
    }

    function isCached()
    {
        if($this->caching == false) return false;
        if(file_exists($this->cacheName) && (time() - strtotime('-'.$this->cachetime) < filemtime($this->cacheName)))
            return true;
        else
            return false;
    }

    function getCache()
    {
        if($this->caching == false) return false;
        $fh = fopen($this->cacheName, 'r');
        $filesize = filesize($this->cacheName);
        $data = fread($fh, $filesize);
        fclose($fh);
        return json_decode($data);
    }

    function set($data)
    {
        if($this->caching == false) return false;
        $json = json_encode( utf8ize($data), JSON_UNESCAPED_UNICODE);
        if(!is_dir('cache'))
            mkdir("cache", 0777, true);
        $fh = fopen($this->cacheName, 'w');
        fwrite($fh, $json);
        fclose($fh);
    }

    function clearCacheAll($path = 'cache/*')
    {
        $files = glob($path);
        foreach($files as $file)
            if(is_file($file))
                unlink($file);
    }
}

function utf8ize($d)
{
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            unset($d[$k]);
            $d[utf8ize($k)] = utf8ize($v);
        }
    } else if (is_object($d)) {
        $objVars = get_object_vars($d);
        foreach($objVars as $key => $value) {
            $d->$key = utf8ize($value);
        }       
    } else if (is_string ($d)) {
        // return iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($d));
        return mb_convert_encoding($d, "UTF-8", "UTF-8");
    }
    return $d;
}

$cache = new Cache;
$cache->cachetime = '1 minutes';
$cache->caching = get_env('CACHE') === 'true' ? true : false;