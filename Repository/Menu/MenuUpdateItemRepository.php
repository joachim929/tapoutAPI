<?php

require_once __DIR__ . '/../../ConnectDb.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Menu/RawMenuItem.php';

class MenuUpdateItemRepository
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
    /**
     * @var DateTime
     */
    private $editedAt;

    public function __construct ()
    {

        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
        $this->editedAt = date('Y-m-d H:i:s');
    }

    /**
     * This function edits menu item details and gives a boolean value whether
     * it was a success or not
     * @param int    $id
     * @param string $title
     * @param string $description
     * @return bool
     */
    public function patchMenuItemDetails (int $id, string $title, string $description)
    {

        $check = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE menu_item_details
            SET title = ?, description = ?, edited_at = ?
            WHERE id = ?'
        );

        $stmt->bind_param('sssi', $title, $description, $this->editedAt, $id);

        $stmt->execute();

        if ($stmt->errno) {
            $check = false;
        }

        $stmt->close();

        return $check;
    }

    /**
     * This function updates editable menu item variables and on success returns
     * item with edited at parameters, otherwise it returns false
     * @param BilingualMenuItem $item
     * @return BilingualMenuItem|false
     */
    public function patchMenuItem (BilingualMenuItem $item)
    {

        $stmt = $this->mysqli->prepare(
            'UPDATE menu_item
            SET category_id = ?, price = ?, category_position = ?,  edited_at = ?
            WHERE id = ?'
        );

        $stmt->bind_param('isisi', $item->categoryId, $item->price, $item->position,
            $this->editedAt, $item->itemId);

        $stmt->execute();

        if ($stmt->errno) {
            $item = false;
        } else {
            $item->setEditedAt($this->editedAt);
        }

        $stmt->close();

        return $item;
    }

    /**
     * This function changes a menu item's category position using an id
     * @param int $id
     * @param int $position
     * @return bool
     */
    public function patchMenuItemPosition (int $id, int $position)
    {

        $check = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE menu_item
            SET category_position = ?
            WHERE id = ?'
        );

        $stmt->bind_param('ii', $position, $id);

        $stmt->execute();

        if ($stmt->errno) {
            $check = false;
        }

        return $check;
    }
}