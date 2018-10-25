<?php


class ConnectDb
{
    // Hold the class instance.
    private static $instance = null;
    private $conn;

    private $mysqli;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'tapout';


    // The db connection is established in the private constructor.
    private function __construct()
    {
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->name);
        mysqli_set_charset($this->mysqli, 'utf8mb4');
    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new ConnectDb();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->mysqli;
    }
}