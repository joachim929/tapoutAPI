<?php

require_once __DIR__ . '/../../ConnectDb.php';

//Repositories
//require_once __DIR__ . '/../../Repository/Menu/MenuItemRespository';

//Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Menu/MenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/MenuItem.php';

class MenuItemService
{
    /**
     * @var
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