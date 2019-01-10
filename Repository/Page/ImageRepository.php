<?php
require_once __DIR__ . '/../../ConnectDb.php';

require_once __DIR__ . '/../../Objects/Image/ImageList.php';

class ImageRepository
{
    /**
     * @var ConnectDb
     */
    private $conn;

    /**
     * @var mysqli
     */
    private $mysqli;

    private $connectDb;

    function __construct()
    {
        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * @todo: Copy from PageItemRepository, remember to remove once you get the time
     * This function gets all page images for a page with a given page id
     * @param int $pageId
     * @return array
     */
    public function getPageImagesByPage(int $pageId)
    {
        $pageImages = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, page_id, img_url, created_at, page_position, caption, alt, height, width, tag, language
            FROM image_details 
            WHERE page_id = ?'
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
     * @todo: Copy from PageItemRepository, remember to remove once you get the time
     * This function gets all info from tapout_page_item table
     * @return array|null
     */
    public function getPageItems()
    {
        $pageItems = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, page_id, heading, content, created_at, edited_at, language, tag, page_position 
            FROM page_item'
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
     * @todo: Copy from PageItemRepository, remember to remove once you get the time
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
            'UPDATE image_details
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
     * @return array|null
     */
    public function getImageList()
    {
        $imageList = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, imgUrl, created_at
            FROM image_list
            WHERE active = 1'
        );

        $stmt->execute();

        $stmt->bind_result($id, $imgUrl, $createdAt);

        while($stmt->fetch()) {
            $imageList[] = new ImageList($id, $imgUrl, $createdAt);
        }

        if($stmt->errno) {
            $imageList = null;
        }

        $stmt->close();

        return $imageList;
    }
}