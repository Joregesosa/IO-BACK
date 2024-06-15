<?php
 
namespace Models;


require_once $_SERVER['DOCUMENT_ROOT'] . '/Config/config.php';

class Database
{
    private $driver;
    private $hostname;
    private $port;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    
    public function __construct()
    {   
 
        $this->driver = $_ENV['DB_CONNECTION'];
        $this->hostname = $_ENV['DB_HOST'];
        $this->port = $_ENV['DB_PORT'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dbname = $_ENV['DB_DATABASE'];


        
        $this->conn = new \PDO("$this->driver:host=$this->hostname;port=$this->port;dbname=$this->dbname", $this->username, $this->password);
 
    }


    function getConn()
    {
        return $this->conn;
    }

    function closeConn()
    {
        $this->conn = null;
    }
}
