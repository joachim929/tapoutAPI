<?php

require_once __DIR__ . '/../../ConnectDb.php';

class MenuReadRepository
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

    public function __construct ()
    {

        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * This function returns a menu item with a given id if it can find one
     * @param int $itemId
     * @return bool|BilingualMenuItem
     */
    public function getItemById (int $itemId)
    {

        $result = false;

        $stmt = $this->mysqli->prepare(
            'SELECT item.id AS itemId, item.price AS itemPrice, item.category_position AS catPosition, 
            item.category_id AS catId, item.created_at AS createdAt, item.edited_at AS editedAt,
            enDetails.id AS enId, enDetails.title AS enTitle, enDetails.description AS enDescription,
            vnDetails.id AS vnId, vnDetails.title AS vnTitle, vnDetails.description AS vnDescription
            FROM menu_item AS item
            LEFT JOIN menu_item_details AS enDetails ON item.id = enDetails.item_id AND enDetails.language = "en"
            LEFT JOIN menu_item_details AS vnDetails ON item.id = vnDetails.item_id AND vnDetails.language = "vn"
            WHERE item.id = ?'
        );

        $stmt->bind_param('i', $itemId);

        $stmt->execute();

        $stmt->bind_result($itemId, $itemPrice, $catPosition, $catId, $createdAt, $editedAt,
            $enId, $enTitle, $enDescription, $vnId, $vnTitle, $vnDescription);

        while ($stmt->fetch()) {
            $result = new BilingualMenuItem($itemPrice, $catPosition, $enTitle, $vnTitle,
                $enDescription, $vnDescription, $enId, $vnId, $itemId);
            $result->setCategoryId($catId);
            $result->setCreatedAt($createdAt);
            $result->setEditedAt($editedAt);
        }

        if ($stmt->errno) {
            $result = false;
        }

        return $result;
    }

    /**
     * This function gets all menu categories, items and descriptions with a given language and
     * returns them in an array of objects
     *
     * @param $language
     * @return array|null
     */
    public function getMenuByLanguage (string $language)
    {

        $results = array();

        $stmt = $this->mysqli->prepare(
            'SELECT cat.id AS catId, cat.en_name AS catEnName, cat.vn_name AS catVnName, 
            cat.type AS catType, cat.page_position AS pagePosition,
            item.id AS itemId, item.price AS itemPrice, item.category_position AS catPosition,
            detail.id AS detailId, detail.title AS detailTitle, detail.description AS detailDescription
            FROM menu_category AS cat 
            LEFT JOIN menu_item AS item ON cat.id = item.category_id
            LEFT JOIN menu_item_details AS detail ON item.id = detail.item_id AND detail.language = ?
            WHERE cat.active = 1
            ORDER BY pagePosition, catPosition'
        );

        $stmt->bind_param('s', $language);

        $stmt->execute();

        $stmt->bind_result($catId, $catEnName, $catVnName, $catType, $pagePosition,
            $itemId, $itemPrice, $catPosition, $detailId, $detailTitle, $detailDescription);

        while ($stmt->fetch()) {
            if ($catPosition !== null && $detailId !== null && $detailTitle !== null &&
                $itemId !== null && $itemPrice !== null
            ) {
                $menuItem = new MenuItem($detailDescription, $catPosition, $itemPrice, $detailTitle, $detailId);
                if ($language === 'en') {
                    if (!isset($results[$catId])) {
                        $results[$catId] = new MenuCategory($catEnName, $catType, $pagePosition, $catId);
                    }
                    $results[$catId]->addItem($menuItem);
                } elseif ($language === 'vn') {
                    if (!isset($results[$catId])) {
                        $results[$catId] = new MenuCategory($catVnName, $catType, $pagePosition, $catId);
                    }
                    $results[$catId]->addItem($menuItem);
                }
            }
        }

        if ($stmt->errno) {
            $results = null;
        }

        $stmt->close();

        return $results;
    }

    /**
     * @param $categoryId
     * @return BilingualMenuCategory|null
     */
    public function getAllItemsByCategory (int $categoryId)
    {

        $result = false;

        $stmt = $this->mysqli->prepare(
            'SELECT cat.id AS catId, cat.en_name AS catEnName, cat.vn_name AS catVnName, cat.type AS catType, cat.page_position AS pagePosition,
            cat.created_at AS catCreatedAt, cat.edited_at AS catEditedAt,
            item.id AS itemId, item.price AS itemPrice, item.category_position AS catPosition, item.created_at AS itemCreatedAt, item.edited_at AS itemEditedAt,
            enDetails.id AS enDetailId, enDetails.title AS enDetailTitle, enDetails.description AS enDetailDescription, 
            vnDetails.id AS vnDetailId, vnDetails.title AS vnDetailTitle, vnDetails.description AS vnDetailDescription
            FROM menu_category AS cat
            LEFT JOIN menu_item AS item ON cat.id = item.category_id
            LEFT JOIN menu_item_details AS enDetails ON item.id = enDetails.item_id AND enDetails.language = "en"
            LEFT JOIN menu_item_details AS vnDetails ON item.id = vnDetails.item_id AND vnDetails.language = "vn"
            WHERE cat.id = ?
            AND cat.active = 1'
        );

        $stmt->bind_param('i', $categoryId);

        $stmt->execute();

        $stmt->bind_result($catId, $catEnName, $catVnName, $catType, $pagePosition, $catCreatedAt, $catEditedAt,
            $itemId, $itemPrice, $catPosition, $itemCreatedAt, $itemEditedAt,
            $enId, $enTitle, $enDescription, $vnId, $vnTitle, $vnDescription);


        while ($stmt->fetch()) {
            if ($result === false) {
                $result = new BilingualMenuCategory($catEnName, $catVnName, $catType, $pagePosition, $catId);
                $result->setCreatedAt($catCreatedAt);
                $result->setEditedAt($catEditedAt);
            }
            if ($itemId !== null) {
                $menuItem = new BilingualMenuItem($itemPrice, $catPosition,
                    $enTitle, $vnTitle, $enDescription, $vnDescription, $enId, $vnId, $itemId);
                $menuItem->setCategoryId($catId);
                $menuItem->setCreatedAt($itemCreatedAt);
                $menuItem->setEditedAt($itemEditedAt);
                $result->addItem($menuItem);
            }
        }

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function gets all menu items, categories and descriptions and puts them in an array of objects
     * @return array|null
     */
    public function getBilingualMenu ()
    {

        $results = array();

        $stmt = $this->mysqli->prepare(
            'SELECT cat.id AS catId, cat.en_name AS catEnName, cat.vn_name AS catVnName, cat.type AS catType, cat.page_position AS pagePosition,
            cat.created_at AS catCreatedAt, cat.edited_at AS catEditedAt,
            item.id AS itemId, item.price AS itemPrice, item.category_position AS catPosition, item.created_at AS itemCreatedAt, item.edited_at AS itemEditedAt,
            enDetails.id AS enDetailId, enDetails.title AS enDetailTitle, enDetails.description AS enDetailDescription, 
            vnDetails.id AS vnDetailId, vnDetails.title AS vnDetailTitle, vnDetails.description AS vnDetailDescription
            FROM menu_category AS cat
            LEFT JOIN menu_item AS item ON cat.id = item.category_id
            LEFT JOIN menu_item_details AS enDetails ON item.id = enDetails.item_id AND enDetails.language = "en"
            LEFT JOIN menu_item_details AS vnDetails ON item.id = vnDetails.item_id AND vnDetails.language = "vn"
            AND cat.active = 1
            ORDER BY pagePosition, catPosition'
        );

        $stmt->execute();

        $stmt->bind_result($catId, $catEnName, $catVnName, $catType, $pagePosition, $catCreatedAt, $catEditedAt,
            $itemId, $itemPrice, $catPosition, $itemCreatedAt, $itemEditedAt,
            $enId, $enTitle, $enDescription, $vnId, $vnTitle, $vnDescription);

        while ($stmt->fetch()) {

            if (!isset($results[$catId])) {
                $results[$catId] = new BilingualMenuCategory($catEnName, $catVnName, $catType, $pagePosition, $catId);
                $results[$catId]->setCreatedAt($catCreatedAt);
                $results[$catId]->setEditedAt($catEditedAt);
            }
            if ($itemId !== null) {
                $menuItem = new BilingualMenuItem($itemPrice, $catPosition,
                    $enTitle, $vnTitle, $enDescription, $vnDescription, $enId, $vnId, $itemId);
                $menuItem->setCategoryId($catId);
                $menuItem->setCreatedAt($itemCreatedAt);
                $menuItem->setEditedAt($itemEditedAt);
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
     * This function gets all menu items by Category Id and Category Position or greater
     * @param int $categoryId
     * @return RawMenuItem[]|bool
     */
    public function getItemsByCategory (int $categoryId)
    {

        $result = false;

        $stmt = $this->mysqli->prepare(
            'SELECT id, category_id, price, category_position, created_at, edited_at
            FROM menu_item
            WHERE category_id = ?
            ORDER BY category_position ASC'
        );

        $stmt->bind_param('i', $categoryId);

        $stmt->execute();

        $stmt->bind_result($id, $catId, $price, $catPosition, $createdAt, $editedAt);

        while ($stmt->fetch()) {
            $result[] = new RawMenuItem($catId, $price, $catPosition, null, null, $id);
        }

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

}