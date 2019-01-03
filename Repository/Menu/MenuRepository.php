<?php
require_once __DIR__ . '/../../ConnectDb.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/NewBilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Menu/NewBilingualMenuCategory.php';

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

        if ($stmt->errno) {
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

        if ($stmt->errno) {
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

    /**
     * @todo: Might need to split call up, see how the database evolves to see if it makes more sense
     * @todo        to get categories AND/OR items separately
     * @todo: Check categories are active
     * @return array|null
     */
    public function newGetBilingualMenu()
    {
        $results = array();

        $stmt = $this->mysqli->prepare(
            'SELECT cat.id AS catId, cat.en_name AS catEnName, cat.vn_name AS catVnName, cat.type AS catType, cat.page_position AS pagePosition,
            item.id AS itemId, item.caption AS itemCaption, item.price AS itemPrice, item.category_position AS catPosition,
            enDetails.id AS enDetailId, enDetails.title AS enDetailTitle, enDetails.description AS enDetailDescription, 
            vnDetails.id AS vnDetailId, vnDetails.title as vnDetailTitle, vnDetails.description AS vnDetailDescription
            FROM menu_category AS cat
            LEFT JOIN menu_item as item ON cat.id = item.category_id
            LEFT JOIN menu_item_details as enDetails ON item.id = enDetails.item_id AND enDetails.language = "en"
            LEFT JOIN menu_item_details as vnDetails ON item.id = vnDetails.item_id AND vnDetails.language = "vn"
            WHERE enDetails.id IS NOT NULL 
            AND vnDetails.id IS NOT NULL
            AND cat.active = 1
            ORDER BY pagePosition, catPosition'
        );

        $stmt->execute();
        // 16
        $stmt->bind_result($catId, $catEnName, $catVnName, $catType, $pagePosition, $itemId, $itemCaption, $itemPrice, $catPosition,
            $enId, $enTitle, $enDescription, $vnId, $vnTitle, $vnDescription);

        while ($stmt->fetch()) {
            $menuItem = new NewBilingualMenuItem($itemPrice, $catPosition, $itemCaption,
                $enTitle, $enDescription, $vnTitle, $vnDescription, $enId, $vnId, $itemId);
            if(!isset($results[$catId])) {
                $results[$catId] = new NewBilingualMenuCategory($catEnName, $catVnName, $catType, $pagePosition, $catId);
            }
            $results[$catId]->addItem($menuItem);
        }

        if ($stmt->errno) {
            $results = null;
        }

        $stmt->close();

        return $results;
    }
}