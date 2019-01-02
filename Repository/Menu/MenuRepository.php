<?php
require_once __DIR__ . '/../../ConnectDb.php';

require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';

class MenuRepository
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

    function __construct()
    {
        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * Copy and paste from ReadMenu
     * This function gets all menu data from category and menu item tables with a given language and returns it in an array
     * @param $language
     * @return array|null
     */
    public function getMenuByLanguage($language)
    {
        $results = array();

        $stmt = $this->mysqli->prepare(
            'SELECT item.*, category.name, category.page_position, category.tag 
        FROM menu_item 
        AS item 
        LEFT JOIN menu_category 
        AS category 
        ON item.category_id = category.id 
        WHERE category.language = ?'
        );

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

        if($stmt->errno) {
            $results = null;
        }

        $stmt->close();

        return $results;
    }

    /**
     * This function gets all menu data regardless of language, and returns it in an array
     * @return array|null
     */
    public function getBilingualMenu()
    {
        $results = array();

        $stmt = $this->mysqli->prepare('
        SELECT item.*, category.name, category.page_position, category.tag, category.language, category.type 
        FROM menu_item 
        AS item 
        LEFT JOIN menu_category 
        AS category 
        ON item.category_id = category.id');

        $stmt->execute();

        $stmt->bind_result($itemId, $categoryId, $title, $price, $description, $categoryPosition,
            $itemTag, $itemLanguage, $categoryName, $pagePosition, $categoryTag, $categoryLanguage, $categoryType);

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
                'categoryLanguage' => $categoryLanguage,
                'categoryType' => $categoryType
            ];
        }

        if($stmt->errno) {
            $results = null;
        }

        $stmt->close();

        return $results;
    }

    /**
     * This function gets all distinct menu category tags and returns an array with null values
     * @return array
     */
    public function getCategoryTags()
    {
        $categoryTags = array();

        $stmt = $this->mysqli->prepare('SELECT DISTINCT tag FROM menu_category');

        $stmt->execute();

        $stmt->bind_result($tag);

        while ($stmt->fetch()) {
            $categoryTags[$tag] = null;
        }

        $stmt->close();
        return $categoryTags;
    }
}