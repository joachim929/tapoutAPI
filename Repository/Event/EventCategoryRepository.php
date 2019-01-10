<?php
require_once __DIR__ . '/../../ConnectDb.php';

//Objects
require_once __DIR__ . '/../../Objects/Events/EventCategory.php';

class EventCategoryRepository extends ConnectDb
{
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
        ConnectDb::__construct();
        $this->conn = ConnectDb::getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * This function gets all categories with a given language
     * @param string $lang
     * @return array|null
     */
    public function getCategoriesByLang(string $lang)
    {
        $categories = array();

        $stmt = $this->mysqli->prepare(
            'SELECT  id, name, type, language, tag, created_at, edited_at, page_position 
            FROM event_category
            WHERE active =  1
            AND language = ? 
            ORDER BY page_position ASC'
        );

        $stmt->bind_param('s', $lang);

        $stmt->execute();

        $stmt->bind_result($id, $name, $type, $language, $tag, $createdAt, $editedAt, $pagePosition);

        while($stmt->fetch()) {
            $categories[] = new EventCategory($name, $type, $language, $tag, $pagePosition, $id, $createdAt, $editedAt);
        }

        if($stmt->errno) {
            $categories = null;
        }

        $stmt->close();

        return $categories;
    }

    /**
     * This function gets all event categories
     * @return array|null
     */
    public function cGetCategories()
    {
        $categories = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, name, type, language, tag, created_at, edited_at, page_position 
            FROM event_category
            WHERE active =  1
            ORDER BY page_position ASC'
        );

        $stmt->execute();

        $stmt->bind_result($id, $name, $type, $language, $tag, $createdAt, $editedAt, $pagePosition);

        while($stmt->fetch()) {
            $categories[] = new EventCategory($name, $type, $language, $tag, $pagePosition, $id, $createdAt, $editedAt);
        }

        if($stmt->errno) {
            $categories = null;
        }

        $stmt->close();

        return $categories;
    }

    /**
     * This function gets all category names
     * @return array|null
     */
    public function getNames()
    {
        $names = array();

        $stmt = $this->mysqli->prepare(
            'SELECT name FROM event_category'
        );

        $stmt->execute();

        $stmt->bind_result($name);

        while ($stmt->fetch()) {
            $names[] = $name;
        }

        if ($stmt->errno) {
            $names = null;
        }

        $stmt->close();

        return $names;
    }

    /**
     * This function gets all category ids
     * @return array|null
     */
    public function getIds()
    {
        $ids = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id FROM event_category'
        );

        $stmt->execute();

        $stmt->bind_result($id);

        while ($stmt->fetch()) {
            $ids[] = $id;
        }

        if ($stmt->errno) {
            $ids = null;
        }

        $stmt->close();

        return $ids;
    }

    /**
     * This function patches a categories page position
     * @param $id
     * @param $position
     * @return bool
     */
    public function patchCategoryPosition(int $id, int $position)
    {
        $check = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE event_category
            SET page_position = ? WHERE id = ?'
        );

        $stmt->bind_param('ii', $position, $id);

        $stmt->execute();

        if($stmt->errno) {
            $check = false;
        }

        $stmt->close();

        return $check;
    }

    /**
     * This function sets a category to inactive "deleting it" with a given Id
     * @param $id
     * @return bool
     */
    public function setInactive(int $id)
    {
        $check = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE event_category
            SET active = 0 WHERE id = ?'
        );

        $stmt->bind_param('i', $id);

        $stmt->execute();

        if($stmt->errno) {
            $check = false;
        }

        $stmt->close();

        return $check;
    }
}