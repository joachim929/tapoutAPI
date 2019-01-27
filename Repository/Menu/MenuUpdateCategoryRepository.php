<?php

require_once __DIR__ . '/../../ConnectDb.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';

class MenuUpdateCategoryRepository
{

    // Variables

    /**
     * @var
     */
    private $connectDb;
    /**
     * @var ConnectDb|null
     */
    private $conn;
    /**
     * @var mysqli
     */
    private $mysqli;
    /**
     * @var DateTime
     */
    private $editedAt;

    public function __construct()
    {

        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
        $this->editedAt = date('Y-m-d H:i:s');
    }


}