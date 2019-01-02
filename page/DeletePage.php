<?php
require_once '../ConnectDb.php';

class DeletePage extends ConnectDb
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
     * This function is the entry point of the class
     */
    public function returnStatement()
    {
        if ($this->checkParams()) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    private function checkParams()
    {
        $result = false;
        if (isset($_POST, $_POST['page'], $_POST['task']) && ($_POST['page'] === 'About' || $_POST['page'] === 'Home'
                || $_POST['page'] === 'Contact' || $_POST['page'] === 'Gallery')) {
            //Case for updating page position
            if ($_POST['task'] === 'deleteItem' && isset($_POST['pageItem'])) {
                $result = $this->checkPageItemType();
            }
        }
        return $result;
    }

    private function checkPageItemType()
    {
        $result = false;
        $postParams = json_decode($_POST['pageItem']);
        //Case for image item
        if(isset($postParams->imgUrl)) {
            $result = $this->deleteImageItem($postParams->id, $postParams->pageId);
        }
        //Case for page item
        else {
            $result = $this->deletePageItem($postParams);
        }
        return $result;
    }

    private function deletePageItem($pageItem)
    {
        $results[] = $this->deleteUsingIds($pageItem->vnItemId, $pageItem->pageId);
        $results[] = $this->deleteUsingIds($pageItem->enItemId, $pageItem->pageId);

        $deleteCheck = true;

        foreach ($results as $result) {
            if($result === false) {
                $deleteCheck = false;
                break;
            }
        }

        return $deleteCheck;
    }

    private function deleteImageItem($imageId, $pageId)
    {
        $result = true;
        $stmt = $this->mysqli->prepare(
            'DELETE FROM image_details
            WHERE id = ?
            AND page_id = ?'
        );

        $stmt->bind_param('ii', $imageId, $pageId);

        $stmt->execute();

        if($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    private function deleteUsingIds($itemId, $pageId)
    {
        $result = true;
        $stmt = $this->mysqli->prepare(
            'DELETE FROM page_item
            WHERE id = ?
            AND page_id = ?'
        );

        $stmt->bind_param('ii', $itemId, $pageId);

        $stmt->execute();

        if($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }
}