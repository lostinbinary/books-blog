<?php if(defined('HEADER_SECURITY') != true) die();

class Book
{
    private $db_handle;

    function __construct($db_handle, $post)
    {
        $this->db_handle = $db_handle;
        foreach($post as $key => $value)
            $this->{$key} = $value;
        
        $this->path = $this->path();
        $this->title = mb_convert_encoding($this->title, 'UTF-8', 'UTF-8');
        $this->description = mb_convert_encoding($this->description, 'UTF-8', 'UTF-8');
    }

    public function path()
    {
        return "/detail/".encode($this->id)."/".slug($this->title);
    }

    public function relateds()
    {
        $books = $this->db_handle->get_query("SELECT * FROM ".get_env('TABLE_LINKS')." WHERE MATCH(title) AGAINST('$this->title') ORDER BY id DESC LIMIT 20");
            
        foreach($books as &$book)
            $book = new Book($this->db_handle, $book);
    
        return $books;
    }

    public function related_keywords()
    {
        $keywords = $this->db_handle->get_query("SELECT * FROM ".get_env('TABLE_KEYWORDS')." WHERE MATCH(keyword) AGAINST('$this->title') ORDER BY id DESC LIMIT 20");
        return $keywords;
    }
}