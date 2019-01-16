<?php

require_once __DIR__ . '/../../ConnectDb.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';

class MenuDeleteRepository
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
     * This function attempts to delete a menu item description
     * @param int $id
     * @return bool
     */
    public function deleteDescription (int $id)
    {

        $result = true;

        $this->mysqli->autocommit(FALSE);

        $stmt = $this->mysqli->prepare(
            'DELETE FROM menu_item_details
            WHERE id = ?'
        );

        $stmt->bind_param('i', $id);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
            $this->mysqli->rollback();
        } else {
            $this->mysqli->commit();
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function attempts to delete a menu item
     * @param int $id
     * @return bool
     */
    public function deleteItem (int $id)
    {

        $result = true;

        $this->mysqli->autocommit(FALSE);

        $stmt = $this->mysqli->prepare(
            'DELETE FROM menu_item
            WHERE id = ?'
        );

        $stmt->bind_param('i', $id);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
            $this->mysqli->rollback();
        } else {
            $this->mysqli->commit();
        }
        $stmt->close();

        return $result;
    }

    /**
     * This function attempts to delete a menu category
     * @param int $id
     * @return bool
     */
    public function deleteCategory (int $id)
    {

        $result = true;

        $this->mysqli->autocommit(FALSE);

        $stmt = $this->mysqli->prepare(
            'DELETE FROM menu_category
            WHERE id = ?'
        );

        $stmt->bind_param('i', $id);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
            $this->mysqli->rollback();
        } else {
            $this->mysqli->commit();
        }
        $stmt->close();

        return $result;
    }
}