<?php
require_once '../ConnectDb.php';

class CreateMenu
{
    /**
     * @var ConnectDb|null
     */
    private $conn;

    /**
     * @var mysqli
     */
    private $mysqli;

    private $connectDb;

    function __construct()
    {
        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
    }
}