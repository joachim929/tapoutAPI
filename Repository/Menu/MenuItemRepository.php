<?php
require_once __DIR__ . '/../../ConnectDb.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/MenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/MenuItem.php';
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';

class MenuItemRepository
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
     * This function creates a new menu item description
     * @param int           $itemId
     * @param string        $title
     * @param string   $description
     * @param string        $language
     * @return bool
     */
    public function insertNewItemDetails(int $itemId, string $title, string $description, string $language)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'INSERT INTO menu_item_details (item_id, title, description, language)
            VALUES (?, ?, ?, ?)'
        );

        $stmt->bind_param('isss', $itemId, $title, $description, $language);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    public function insertNewItemDetailsNoDesc(int $itemId, string $title, string $language)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'INSERT INTO menu_item_details (item_id, title, language)
            VALUES (?, ?, ?)'
        );

        $stmt->bind_param('iss', $itemId, $title, $language);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function creates a new menu item
     * @param int    $catId
     * @param string $caption
     * @param string $price
     * @param int    $position
     * @return boo
     */
    public function insertNewItem(int $catId, string $caption, string $price, int $position)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'INSERT INTO menu_item (category_id, caption, price, category_position)
            VALUES (?, ?, ?, ?)'
        );

        $stmt->bind_param('issi', $catId, $caption, $price, $position);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function gets a menu item using caption as an arguement
     * @param string $caption
     * @return bool|stdClass
     */
    public function getItemByCaption(string $caption)
    {
        $stmt = $this->mysqli->prepare(
            'SELECT id, category_id, caption, price, category_position
            FROM menu_item
            WHERE caption = ?'
        );

        $stmt->bind_param('s', $caption);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $caption, $price, $categoryPosition);

        $stmt->fetch();

        if($stmt->errno) {
            $result = false;
        } else {
            $result = new stdClass();
            $result->id = $id;
            $result->categoryId = $categoryId;
            $result->caption = $caption;
            $result->price = $price;
            $result->categoryPosition = $categoryPosition;
        }

        return $result;
    }

    /**
     * This function gets all menu items with a given category Id and returns it in an array
     * @param int $categoryId
     * @return array|bool
     */
    public function cgetItemsByCategory(int $categoryId)
    {
        $result = [];
        $index = 0;
        $stmt = $this->mysqli->prepare(
            'SELECT id, category_id, caption, price, category_position
            FROM menu_item
            WHERE category_id = ?
            ORDER BY category_position ASC'
        );

        $stmt->bind_param('i', $categoryId);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $caption, $price, $categoryPosition);

        while ($stmt->fetch()) {
            $result[$index] = new stdClass();
            $result[$index]->id = $id;
            $result[$index]->categoryId = $categoryId;
            $result[$index]->caption = $caption;
            $result[$index]->price = $price;
            $result[$index]->categoryPosition = $categoryPosition;
            $index++;
        }

        if($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }


    /**
     * This function edits a menu item using an id
     * @param int    $id
     * @param int    $categoryId
     * @param string $caption
     * @param string $price
     * @param int    $categoryPosition
     * @return bool
     */
    public function patchItem(int $id, int $categoryId, string $caption,
                              string $price, int $categoryPosition) {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE menu_item
            SET category_id = ?, caption = ?, price = ?, category_position = ?
            WHERE id = ?'
        );

        $stmt->bind_param('issii', $categoryId, $caption, $price, $categoryPosition, $id);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }
}