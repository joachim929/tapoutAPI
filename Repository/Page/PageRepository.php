<?php
require_once __DIR__ . '/../../ConnectDb.php';

class PageRepository extends ConnectDb
{
    /**
     * @var ConnectDb|null
     */
    private $conn;

    /**
     * @var mysqli
     */
    private $mysqli;

    public function __construct()
    {
        ConnectDb::__construct();
        $this->conn = ConnectDb::getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * This function gets a page id by page name
     * @param $pageName
     * @return int|null
     */
    public function getPageId($pageName)
    {
        $pageId = null;

        $stmt = $this->mysqli->prepare(
            'SELECT id FROM page WHERE name = ?'
        );

        $stmt->bind_param('s', $pageName);

        $stmt->execute();

        $stmt->bind_result($pageId);

        $stmt->fetch();

        if($stmt->errno) {
            $pageId = null;
        }

        $stmt->close();

        return $pageId;
    }

}