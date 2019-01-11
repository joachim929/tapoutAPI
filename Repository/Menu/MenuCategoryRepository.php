<?php
require_once __DIR__ . '/../../ConnectDb.php';

class MenuCategoryRepository
{
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

    public function __construct()
    {
        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * This function gets all distinct menu category tags and returns an array with null values
     * @return array
     */
    public function getCategories()
    {
        $categories= array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, en_name, vn_name, type, page_position 
            FROM menu_category
            WHERE active = 1'
        );

        $stmt->execute();

        $stmt->bind_result($id, $enName, $vnName, $type, $pagePosition);

        while ($stmt->fetch()) {
            $categories[] = new BilingualMenuCategory($enName, $vnName, $type, $pagePosition, $id);

        }

        $stmt->close();
        return $categories;
    }

    /**
     * This function selects category information with a given Id
     * @param $id
     * @return BilingualMenuCategory|null
     */
    public function getCategoryById($id)
    {
        $stmt = $this->mysqli->prepare(
            'SELECT id, en_name, vn_name, type, page_position
            FROM menu_category
            WHERE active = 1
            AND id = ?'
        );

        $stmt->bind_param('i', $id);

        $stmt->execute();

        $stmt->bind_result($id, $enName, $vnName, $type, $pagePosition);

        $stmt->fetch();

        if($stmt->errno) {
            $category = null;
        } else {
            $category = new BilingualMenuCategory($enName, $vnName, $type, $pagePosition, $id);
        }
        return $category;
    }
}