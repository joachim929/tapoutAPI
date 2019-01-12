<?php

require_once __DIR__ . '/../../ConnectDb.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';

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

        $this->mysqli->commit();

        if ($stmt->errno) {
            $check = false;
            $this->mysqli->rollback();
        } else {
            $check = $stmt->insert_id;
        }

        $stmt->close();

        return $check;
    }

}