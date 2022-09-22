<?php if(defined('HEADER_SECURITY') != true) die();

class Book
{
    private $db_handle;

    function __construct($db_handle, $post)
    {
        $this->db_handle = $db_handle;
        foreach($post as $key => $value)
            $this->{$key} = $value;
    }

    public function path()
    {
        return "/detail/".encode($this->id)."/".slug($this->title);
    }

    public function relateds()
    {
        $books = $this->db_handle->get_query("SELECT * FROM israelpdf1_db WHERE MATCH(title) AGAINST('$this->title') ORDER BY id DESC LIMIT 8");
            
        foreach($books as &$book)
            $book = new Book($this->db_handle, $book);
    
        return $books;
    }

    public function related_keywords()
    {
        $keywords = $this->db_handle->get_query("SELECT * FROM israelpdf1_key WHERE MATCH(keyword) AGAINST('$this->title') ORDER BY id DESC");
        return $keywords;
    }
}