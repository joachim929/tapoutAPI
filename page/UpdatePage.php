<?php
require_once '../ConnectDb.php';

class UpdatePage extends ConnectDb
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
            if ($_POST['task'] === 'pagePosition' && isset($_POST['pageItems'])) {
                $result = $this->updatePagePosition();
            }
            //Case for updating a page item
            elseif ($_POST['task'] === 'pageItem' && isset($_POST['pageItem'])) {

            }
        }
        return $result;
    }

    private function updatePagePosition()
    {
        $results = array();
        $postParams = json_decode($_POST['pageItems']);
        if(count($postParams) < 2) {
            return false;
        } else {
            foreach($postParams as $postParam) {
                if(isset($postParam->imgUrl)) {
                    //Update image object
                    $results[] = $this->updateImageItemPosition($postParam);
                } else {
                    //Update page item object
                    $results[] = $this->prepPageItemPositionUpdate($postParam);
                }
            }
        }
        return $this->checkResults($results);
    }

    private function checkResults($results)
    {
        $success = true;
        foreach ($results as $result) {
            if($result === false) {
                $success = false;
                break;
            }
        }
        return $success;
    }

    private function prepPageItemPositionUpdate($pageItem)
    {
        if(isset($pageItem->pagePosition, $pageItem->enItemId, $pageItem->vnItemId, $pageItem->pageId)) {
            return $this->updatePageItemPosition($pageItem->pagePosition, $pageItem->enItemId, $pageItem->pageId)
                && $this->updatePageItemPosition($pageItem->pagePosition, $pageItem->vnItemId, $pageItem->pageId);
        } else {
            return false;
        }
    }

    private function updatePageItemPosition($pagePosition, $itemId, $pageId)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE tapout_page_item
            SET page_position = ?
            WHERE id = ?
            AND page_id = ?'
        );

        $stmt->bind_param('iii', $pagePosition, $itemId, $pageId);

        $stmt->execute();

        if($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    private function updateImageItemPosition($imageItem)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE tapout_image 
            SET page_position = ? 
            WHERE id = ? 
            AND page_id = ?'
        );

        $stmt->bind_param('iii', $imageItem->pagePosition, $imageItem->id, $imageItem->pageId);

        $stmt->execute();

        if($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }
}