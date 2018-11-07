<?php

/**
 * Created by PhpStorm.
 * User: J-Lap2
 * Date: 11/7/2018
 * Time: 8:09 PM
 */
class GetEventsToEdit extends ConnectDb
{
    /**
     * @var ConnectDb|null
     */
    private $conn;

    /**
     * @var mysqli
     */
    private $mysqli;

    function __construct()
    {
        ConnectDb::__construct();
        $this->conn = ConnectDb::getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    function closeConn()
    {
        $this->conn = null;
    }
}