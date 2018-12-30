<?php
require_once '../ConnectDb.php';

require_once '../Objects/PageItem.php';
require_once '../Objects/PageImage.php';

//@todo split into image and page item?
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
     * This function gets all page items for a page with a given id
     * @param int $pageId
     * @return array|null
     */
    public function getPageItemsByPage(int $pageId)
    {
        $pageItems = array();

        $stmt = $this->mysqli->prepare(
            'SELECT * FROM tapout_page_item WHERE page_id = ?'
        );

        $stmt->bind_param('i', $pageId);

        $stmt->execute();

        $stmt->bind_result($id, $pageId, $heading, $content, $createdAt, $editedAt, $language, $tag, $pagePosition);

        while ($stmt->fetch()) {
            $pageItems[] = new PageItem ($pageId, $heading, $content, $language, $tag, $pagePosition, $id, $createdAt, $editedAt);
        }

        if ($stmt->errno) {
            $pageItems = null;
        }

        $stmt->close();

        return $pageItems;
    }

    /**
     * This function gets all page images for a page with a given page id
     * @param int $pageId
     * @return array
     */
    public function getPageImagesByPage(int $pageId)
    {
        $pageImages = array();

        $stmt = $this->mysqli->prepare(
            'SELECT * FROM tapout_image WHERE page_id = ?'
        );

        $stmt->bind_param('i', $pageId);

        $stmt->execute();

        $stmt->bind_result($id, $pageId, $imgUrl, $createdAt, $pagePosition, $caption, $alt,
            $height, $width, $tag, $language);

        while ($stmt->fetch()) {
            $pageImages[] = new PageImage($pageId, $imgUrl, $pagePosition, $height, $width,
                $tag, $language, $caption, $alt, $createdAt, $id);
        }

        if ($stmt->errno) {
            $pageItems = null;
        }

        $stmt->close();

        return $pageImages;
    }

    /**
     * This function gets all info from tapout_page_item table
     * @return array|null
     */
    public function getPageItems()
    {
        $pageItems = array();

        $stmt = $this->mysqli->prepare(
            'SELECT * 
            FROM tapout_page_item'
        );

        $stmt->execute();

        $stmt->bind_result($id, $pageId, $heading, $content, $createdAt, $editedAt, $language,
            $tag, $pagePosition);

        while ($stmt->fetch()) {
            $pageItems[] = new PageItem ($pageId, $heading, $content, $language, $tag, $pagePosition, $id, $createdAt, $editedAt);
        }

        if ($stmt->errno) {
            $pageItems = null;
        }

        $stmt->close();

        return $pageItems;
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
     * This function updates the page position for a page image
     * @param int $id
     * @param int $pagePosition
     * @param int $pageId
     * @return bool
     */
    public function updateImagePagePosition(int $id, int $pagePosition, int $pageId)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE tapout_image
            SET page_position = ? WHERE id = ? AND page_id = ?'
        );

        $stmt->bind_param('iii', $pagePosition, $id, $pageId);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function updates the page position for a page item
     * @param int $id
     * @param int $pagePosition
     * @param int $pageId
     * @return bool
     */
    public function updateItemPagePosition(int $id, int $pagePosition, int $pageId)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE tapout_page_item
            SET page_position = ?
            WHERE id = ?
            AND page_id = ?'
        );

        $stmt->bind_param('iii', $pagePosition, $id, $pageId);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }
}