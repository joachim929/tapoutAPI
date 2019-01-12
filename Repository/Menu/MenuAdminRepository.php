<?php

require_once __DIR__ . '/../../ConnectDb.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Menu/RawMenuItem.php';

class MenuAdminRepository
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
     * This function attempts to insert new item details, on success it returns the id
     * On failure it returns false
     * @param int    $itemId
     * @param string $title
     * @param string $description
     * @param string $language
     * @return bool|int
     */
    public function newItemDetails(int $itemId, string $title, string $description, string $language)
    {
        $this->mysqli->autocommit(FALSE);

        $stmt = $this->mysqli->prepare(
            'INSERT INTO menu_item_details
            (item_id, title, description, language)
            VALUES (?, ?, ?, ?)'
        );

        $stmt->bind_param('isss', $itemId, $title, $description, $language);

        $stmt->execute();

        if ($stmt->errno) {
            $check = false;
            $this->mysqli->rollback();
        } else {
            $check = $stmt->insert_id;
        }

        $this->mysqli->commit();

        $stmt->close();

        return $check;
    }

    /**
     * This function inserts a new menu_item entry and returns either false if it
     * failed and rolled back or returns the created menu_item id
     * @param $item
     * @return bool|int
     */
    public function newItem(BilingualMenuItem $item)
    {
        $this->mysqli->autocommit(FALSE);

        $stmt = $this->mysqli->prepare(
            'INSERT INTO menu_item
                (category_id, caption, price, category_position)
                 VALUES (?, ?, ?, ?)'
        );

        $stmt->bind_param('issi',
            $item->categoryId, $item->caption, $item->price, $item->position);

        $stmt->execute();

        if ($stmt->errno) {
            $check = false;
            $this->mysqli->rollback();
        } else {
            $check = $stmt->insert_id;
        }

        $this->mysqli->commit();

        $stmt->close();

        return $check;
    }

    /**
     * This function creates a new menu category, if it succeeds it returns the id, otherwise false
     * @param BilingualMenuCategory $params
     * @return bool|int
     */
    public function newCategory(BilingualMenuCategory $params)
    {
        $stmt = $this->mysqli->prepare(
            'INSERT INTO menu_category
            (en_name, vn_name, type, page_position)
            VALUES (?, ?, ?, ?)'
        );

        $stmt->bind_param('sssi', $params->enName, $params->vnName, $params->type, $params->position);

        $stmt->execute();

        if ($stmt->errno) {
            $check = false;
        } else {
            $check = $stmt->insert_id;
        }

        $stmt->close();

        return $check;
    }

    /**
     * This function gets all Menu items with a given category Id and returns them in an array
     * @param $catId
     * @return RawMenuItem[]|bool
     */
    public function getAllMenuItemsByCategory($catId)
    {
        $results = false;

        $stmt = $this->mysqli->prepare(
            'SELECT id, category_id, caption, price, category_position, created_at, edited_at
            FROM menu_item
            WHERE category_id = ?
            ORDER BY category_position ASC'
        );

        $stmt->bind_param('i', $catId);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $caption, $price, $categoryPosition, $createdAt, $editedAt);

        while($stmt->fetch()) {
            $results[] = new RawMenuItem($caption, $categoryId, $price, $categoryPosition,
                $createdAt, $editedAt, $id);
        }

        if ($stmt->errno) {
            $results = false;
        }

        return $results;
    }

    /**
     * This function patches a menu items position in a category
     * @param RawMenuItem $item
     * @return bool
     */
    public function patchMenuItem(RawMenuItem $item)
    {
        $this->mysqli->autocommit(FALSE);

        $result = false;

        $stmt = $this->mysqli->prepare(
            'UPDATE menu_item
            SET category_position = ?
            WHERE id = ?'
        );

        $stmt->bind_param('ii', $item->position, $item->id);

        $stmt->execute();

        if ($stmt->errno) {
            $this->mysqli->rollback();
        } else {
            $this->mysqli->commit();
            $result = true;
        }

        $stmt->close();

        return $result;
    }
}