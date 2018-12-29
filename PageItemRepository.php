<?php
require_once '../ConnectDb.php';

class PageItemRepository extends ConnectDb
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
     * This function gets all info from tapout_page_item table
     * @return array|int
     */
    public function getPagesItems()
    {
        $pages = array();

        $stmt = $this->mysqli->prepare(
            'SELECT * 
            FROM tapout_page_item'
        );

        $stmt->execute();

        $stmt->bind_result($id, $pageId, $heading, $content, $createdAt, $editedAt, $language,
            $tag, $pagePosition);

        while ($stmt->fetch()) {
            $pages[] = [
                'id' => $id,
                'pageId' => $pageId,
                'heading' => $heading,
                'content' => $content,
                'createdAt' => $createdAt,
                'editedAt' => $editedAt,
                'language' => $language,
                'tag' => $tag,
                'pagePosition' => $pagePosition
            ];
        }

        if ($stmt->errno) {
            $pages = $stmt->errno;

        }

        $stmt->close();

        return $pages;
    }

    /**
     * Finds highest id value and returns it
     * @return int|null
     */
    public function getLastId()
    {
        $id = null;

        $stmt = $this->mysqli->prepare(
            'SELECT MAX(id) FROM tapout_page_item'
        );

        $stmt->execute();

        $stmt->bind_result($id);

        $stmt->fetch();

        if ($stmt->errno) {
            $id = null;
        }

        $stmt->close();

        return $id;
    }

    /**
     * This function gets all distinct tags
     * @return array|int
     */
    public function getItemTags()
    {
        $tags = array();

        $stmt = $this->mysqli->prepare(
            'SELECT DISTINCT tag
            FROM tapout_page_item'
        );

        $stmt->execute();

        $stmt->bind_result($tag);

        while ($stmt->fetch()) {
            $tags[] = $tag;
        }

        if ($stmt->errno) {
            $tags = $stmt->errno;
        }

        $stmt->close();

        return $tags;
    }

    /**
     * This function deletes a record with a given tag
     * @param $tag
     * @return bool
     */
    public function deleteByTag($tag)
    {
        $result = true;
        $stmt = $this->mysqli->prepare(
            'DELETE FROM tapout_page_item WHERE tag = ?'
        );

        $stmt->bind_param('i', $tag);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function gets items with a given tag
     * @param $tag
     * @return array|null
     */
    public function getItemsByTag($tag)
    {
        $result = null;
        $stmt = $this->mysqli->prepare(
            'SELECT * 
          FROM tapout_page_item
          WHERE tag = ?'
        );

        $stmt->bind_param('s', $tag);

        $stmt->execute();

        $stmt->bind_result($id, $pageId, $heading, $content, $createdAt, $editedAt, $language, $tag, $pagePosition);

        if ($stmt->errno) {
            $result = null;
        } else {
            while ($stmt->fetch()) {
                $result[] = [
                    'id' => $id,
                    'pageId' => $pageId,
                    'heading' => $heading,
                    'content' => $content,
                    'createdAt' => $createdAt,
                    'editedAt' => $editedAt,
                    'language' => $language,
                    'tag' => $tag,
                    'pagePosition' => $pagePosition
                ];
            }
        }

        return $result;
    }

}