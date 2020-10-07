<?php

// Database configurations, depending on localhost or hosting service
session_start();

error_reporting(-1);
ini_set("display_errors", 1);

/*define("DBHOST", "localhost");
define("DBUSER", "WebbutvecklingIII_kurser");
define("DBPASS", "password");
define("DBDATABASE", "webbutvecklingiii_kurser");*/

define("DBHOST", "studentmysql.miun.se");
define("DBUSER", "olfa1902");
define("DBPASS", "qc9fenyg");
define("DBDATABASE", "olfa1902");


/*class Database
{
    /* Database configurations 
    private $host = 'localhost';
    private $db_name = 'webbutvecklingiii_kurser';
    private $username = 'webbutvecklingiii_kurser';
    private $password = 'password';
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error " . $e->getMessage();
        }
        return $this->conn;
    }
    public function close()
    {
        $this->conn = null;
    }
}*/
