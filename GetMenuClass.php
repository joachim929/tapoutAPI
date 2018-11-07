<?php

/**
 * Created by PhpStorm.
 * User: J-Lap2
 * Date: 10/27/2018
 * Time: 7:29 PM
 */
class GetMenu extends ConnectDb
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

    public function cgetMenuToEdit() {
        $results = array();

        $stmt = $this->mysqli->prepare('
        SELECT item.*, category.name, category.page_position, category.tag, category.language 
        FROM tapout_menu_item 
        AS item 
        LEFT JOIN tapout_menu_category 
        AS category 
        ON item.category_id = category.id');

        $stmt->execute();

        $stmt->bind_result($itemId, $categoryId, $title, $price, $description, $categoryPosition,
            $itemTag, $itemLanguage, $categoryName, $pagePosition, $categoryTag, $categoryLanguage);

        while ($stmt->fetch()) {
            $results[] = [
                'id' => $itemId,
                'categoryId' => $categoryId,
                'title' => $title,
                'price' => $price,
                'description' => $description,
                'categoryPosition' => $categoryPosition,
                'itemTag' => $itemTag,
                'itemLanguage' => $itemLanguage,
                'categoryName' => $categoryName,
                'pagePosition' => $pagePosition,
                'categoryTag' => $categoryTag,
                'categoryLanguage' => $categoryLanguage
            ];
        }

        $stmt->close();
        return $results;
    }

    public function getCategoryTags() {
        $results = array();

        $stmt = $this->mysqli->prepare('SELECT DISTINCT tag FROM tapout_menu_category');

        $stmt->execute();

        $stmt->bind_result($categoryTag);

        while ($stmt->fetch()) {
            $results[$categoryTag] = array();
        }

        $stmt->close();
        return $results;
    }

    public function cgetMenu($language)
    {
        $results = array();

        $stmt = $this->mysqli->prepare('SELECT item.*, category.name, category.page_position, category.tag 
        FROM tapout_menu_item 
        AS item 
        LEFT JOIN tapout_menu_category 
        AS category 
        ON item.category_id = category.id 
        WHERE category.language = ?');

        $stmt->bind_param('s', $language);

        $stmt->execute();

        $stmt->bind_result($itemId, $categoryId, $title, $price, $description, $categoryPosition,
            $itemTag, $language, $categoryName, $pagePosition, $categoryTag);

        while ($stmt->fetch()) {
            $results[] = [
                'id' => $itemId,
                'categoryId' => $categoryId,
                'title' => $title,
                'price' => $price,
                'description' => $description,
                'categoryPosition' => $categoryPosition,
                'itemTag' => $itemTag,
                'categoryName' => $categoryName,
                'pagePosition' => $pagePosition,
                'categoryTag' => $categoryTag

            ];
        }

        $stmt->close();
        return $results;
    }

    public function sortCategories($results) {
        $sortedCategories = array();

        foreach ($results as $result) {
            $itemArray = [
                'id' => $result['id'],
                'title' => $result['title'],
                'price' => $result['price'],
                'description' => $result['description'],
                'categoryPosition' => $result['categoryPosition'],
                'itemTag' => $result['itemTag']
            ];
            if(!isset($sortedCategories['category'][$result['categoryId']])){
                $sortedCategories['category'][$result['categoryId']] = [
                    'id' => $result['categoryId'],
                    'pagePosition' => $result['pagePosition'],
                    'name' => $result['categoryName'],
                    'categoryTag' => $result['categoryTag'],
                    'items' => [ $itemArray ]
                ];
            } else {
                $sortedCategories['category'][$result['categoryId']]['items'][] = $itemArray;
            }
        }

        return $sortedCategories;
    }
}