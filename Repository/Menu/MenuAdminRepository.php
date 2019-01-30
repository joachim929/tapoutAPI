<?php

require_once __DIR__ . '/../../ConnectDb.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Menu/RawMenuItem.php';

class MenuAdminRepository
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
     * This function attempts to insert new item details, on success it returns the id
     * On failure it returns false
     * @param int    $itemId
     * @param string $title
     * @param string|null $description
     * @param string $language
     * @return bool|int
     */
    public function newItemDetails (int $itemId, string $title, $description, string $language)
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
    public function newItem (BilingualMenuItem $item)
    {

        $this->mysqli->autocommit(FALSE);

        $stmt = $this->mysqli->prepare(
            'INSERT INTO menu_item
                (category_id, price, category_position)
                 VALUES (?, ?, ?)'
        );

        $stmt->bind_param('isi',
            $item->categoryId, $item->price, $item->position);

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
    public function newCategory (BilingualMenuCategory $params)
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
    public function getAllMenuItemsByCategory ($catId)
    {

        $results = false;

        $stmt = $this->mysqli->prepare(
            'SELECT id, category_id, price, category_position, created_at, edited_at
            FROM menu_item
            WHERE category_id = ?
            ORDER BY category_position ASC'
        );

        $stmt->bind_param('i', $catId);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $price, $categoryPosition, $createdAt, $editedAt);

        while ($stmt->fetch()) {
            $results[] = new RawMenuItem($categoryId, $price, $categoryPosition,
                new DateTime($createdAt), new DateTime($editedAt), $id);
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
    public function patchMenuItemPosition (RawMenuItem $item)
    {

        $this->mysqli->autocommit(FALSE);

        $editedAt = date('Y-m-d H:i:s');

        $result = false;

        $stmt = $this->mysqli->prepare(
            'UPDATE menu_item
            SET category_position = ?, edited_at = ?
            WHERE id = ?'
        );

        $stmt->bind_param('isi', $item->position, $editedAt, $item->id);

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

    /**
     * This function gets all active categories and on success returns them in an array of BilingualMenuCategory
     * @return BilingualMenuCategory[]|bool
     */
    public function getAllCategories ()
    {

        $categories = [];

        $stmt = $this->mysqli->prepare(
            'SELECT id, en_name, vn_name, type, page_position, created_at, edited_at
            FROM menu_category
            WHERE active = 1
            ORDER BY page_position ASC'
        );

        $stmt->execute();

        $stmt->bind_result($id, $enName, $vnName, $type, $pagePosition, $createdAt, $editedAt);

        while ($stmt->fetch()) {
            $categories[] = new BilingualMenuCategory($enName, $vnName, $type, $pagePosition,
                $id, $createdAt, $editedAt);
        }

        if ($stmt->errno) {
            $categories = false;
        }

        return $categories;
    }

    /**
     * This function patches a menu category position in a category
     * @param BilingualMenuCategory $category
     * @return bool
     */
    public function patchCategoryPosition (BilingualMenuCategory $category)
    {
        $this->mysqli->autocommit(FALSE);
        $check = true;

        $editedAt = date('Y-m-d H:i:s');

        $stmt = $this->mysqli->prepare(
            'UPDATE menu_category
            SET page_position = ?, edited_at = ?
            WHERE id = ?'
        );

        $stmt->bind_param('isi', $category->position, $editedAt, $category->id);

        $stmt->execute();

        if ($stmt->errno) {
            $this->mysqli->rollback();
        } else {
            $this->mysqli->commit();
            $check = true;
        }

        $stmt->close();

        return $check;
    }
}