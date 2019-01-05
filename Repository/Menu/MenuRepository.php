<?php
require_once __DIR__ . '/../../ConnectDb.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/MenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/MenuItem.php';
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';

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

    public function getMenuByLanguage($language)
    {
        $results = array();

        $stmt = $this->mysqli->prepare(
            'SELECT cat.id AS catId, cat.en_name AS catEnName, cat.vn_name AS catVnName, 
            cat.type AS catType, cat.page_position AS pagePosition,
            item.id AS itemId, item.price AS itemPrice, item.category_position AS catPosition,
            detail.id AS detailId, detail.title AS detailTitle, detail.description AS detailDescription
            FROM menu_category AS cat 
            LEFT JOIN menu_item as item ON cat.id = item.category_id
            LEFT JOIN menu_item_details AS detail ON item.id = detail.item_id AND detail.language = ?
            WHERE cat.active = 1
            ORDER BY pagePosition, catPosition'
        );

        $stmt->bind_param('s', $language);

        $stmt->execute();

        $stmt->bind_result($catId, $catEnName, $catVnName, $catType, $pagePosition,
            $itemId, $itemPrice, $catPosition, $detailId, $detailTitle, $detailDescription);

        while ($stmt->fetch()) {
            $menuItem = new MenuItem($detailDescription, $catPosition, $itemPrice, $detailTitle, $detailId);
            if($language === 'en') {
                if(!isset($results[$catId])) {
                    $results[$catId] = new MenuCategory($catEnName, $catType, $pagePosition, $catId);
                }
                $results[$catId]->addItem($menuItem);
            } elseif ($language === 'vn') {
                if(!isset($results[$catId])) {
                    $results[$catId] = new MenuCategory($catVnName, $catType, $pagePosition, $catId);
                }
                $results[$catId]->addItem($menuItem);
            }
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
     * @return array|null
     */
    public function getBilingualMenu()
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

        $stmt->bind_result($catId, $catEnName, $catVnName, $catType, $pagePosition, $itemId, $itemCaption, $itemPrice, $catPosition,
            $enId, $enTitle, $enDescription, $vnId, $vnTitle, $vnDescription);

        while ($stmt->fetch()) {
            $menuItem = new BilingualMenuItem($itemPrice, $catPosition, $itemCaption,
                $enTitle, $enDescription, $vnTitle, $vnDescription, $enId, $vnId, $itemId);
            if(!isset($results[$catId])) {
                $results[$catId] = new BilingualMenuCategory($catEnName, $catVnName, $catType, $pagePosition, $catId);
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