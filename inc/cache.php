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

    function setCache($data)
    {
        if($this->caching == false) return false;
        $json = json_encode($data);
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

$cache = new Cache;
$cache->cachetime = '1 minutes';
$cache->caching = false;