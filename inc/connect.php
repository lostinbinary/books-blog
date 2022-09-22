<?php if(defined('HEADER_SECURITY') != true) die();

class DBConnect
{
    private $host;
    private $user;
    private $password;
    private $database;

    private $db;

    function __construct()
    {
        $this->db_connect();
    }

    public function db_connect()
    {
        $this->host     = get_env('DB_HOST');
        $this->user     = get_env('DB_USERNAME');
        $this->password = get_env('DB_PASSWORD');
        $this->database = get_env('DB_DATABASE');
        $this->db = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password) or die("Cannot connect to mySQL.");
        return $this->db;
    }

    public function get_query($query, $params = [], $first = false) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $result = false;
        if(!$first)
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        else
            $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function update_query($query, $params = [], $key = false) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        if($key) $this->db->lastInsertId();
        return false;
    }

}

$db_handle = new DBConnect;
$db = $db_handle->db_connect();