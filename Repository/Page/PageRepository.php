<?php
require_once '../../ConnectDb.php';

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

    function __construct()
    {
        ConnectDb::__construct();
        $this->conn = ConnectDb::getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * This function gets all info from tapout_page table
     * @return array|null
     */
    public function getPages()
    {
        $pages = array();

        $stmt = $this->mysqli->prepare(
            'SELECT * 
            FROM tapout_page'
        );

        $stmt->execute();

        $stmt->bind_result($id, $name);

        while($stmt->fetch()) {
            $pages[] = [
                'id' => $id,
                'name' => $name
            ];
        }

        if ($stmt->errno) {
            $pages = null;
        }

        $stmt->close();

        return $pages;
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
            'SELECT id FROM tapout_page WHERE name = ?'
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