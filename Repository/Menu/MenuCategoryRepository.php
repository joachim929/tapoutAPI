<?php
require_once __DIR__ . '/../../ConnectDb.php';

class MenuCategoryRepository
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
     * @return BilingualMenuCategory[]
     */
    public function getCategories ()
    {

        $categories = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, en_name, vn_name, type, page_position 
            FROM menu_category
            WHERE active = 1
            ORDER BY page_position ASC'
        );

        $stmt->execute();

        $stmt->bind_result($id, $enName, $vnName, $type, $pagePosition);

        while ($stmt->fetch()) {
            $categories[] = new BilingualMenuCategory($enName, $vnName, $type, $pagePosition, $id);
        }

        $stmt->close();

        return $categories;
    }

    /**
     * This function patches a category with a given id, on success it returns the
     * edited category, on failure it returns false
     * @param BilingualMenuCategory $category
     * @return BilingualMenuCategory|bool
     */
    public function patchMenuCategory(BilingualMenuCategory $category)
    {

        $stmt = $this->mysqli->prepare(
            'UPDATE menu_category
            SET en_name = ?, vn_name = ?, type = ?, page_position = ?, edited_at = ?
            WHERE id = ?'
        );

        $stmt->bind_param('sssisi', $category->enName, $category->vnName, $category->type,
            $category->position, $this->editedAt, $category->id);

        $stmt->execute();

        if ($stmt->errno) {
            $category = false;
        } else {
            $category->setEditedAt($this->editedAt);
        }

        $stmt->close();

        return $category;
    }

}