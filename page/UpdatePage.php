<?php
require_once '../ConnectDb.php';

class UpdatePage
{
    /**
     * @var ConnectDb|null
     */
    private $conn;

    /**
     * @var mysqli
     */
    private $mysqli;

    private $connectDb;

    private $page = null;
    private $task = null;
    private $pageItems = null;
    private $pageItem = null;

    public function __construct()
    {
        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
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

    /**
     * This function checks all the Post params, if they are correct functions are called to update a page item
     * @return bool
     */
    private function checkParams()
    {
        $result = false;
        if (isset($_POST, $_POST['page'], $_POST['task']) && ($_POST['page'] === 'About' || $_POST['page'] === 'Home'
                || $_POST['page'] === 'Contact' || $_POST['page'] === 'Gallery')
        ) {
            $this->page = $_POST['page'];
            //Case for updating page position
            if ($_POST['task'] === 'pagePosition' && isset($_POST['pageItems'])) {
                $this->task = $_POST['task'];
                $this->pageItems = json_decode($_POST['pageItems']);
                $result = $this->updatePagePosition();
            } //Case for updating a page item
            elseif ($_POST['task'] === 'updatePageItem' && isset($_POST['pageItem'])) {
                $this->task = $_POST['task'];
                $this->pageItem = json_decode($_POST['pageItem']);
                $result = $this->initializeEdit();
            }
        }
        return $result;
    }

    private function pageImageValidationCheck()
    {
        // @todo still needs to be written
        return true;
    }

    /**
     * This function is a switch for page items and images
     * @return bool
     */
    private function initializeEdit()
    {
        $result = false;
        if (isset($this->pageItem->imgUrl) && $this->pageImageValidationCheck()) {
            $result = true;
        } elseif ($this->pageItemValidationCheck()) {
            $enItem = $this->createTempPageItem('en');
            $vnItem = $this->createTempPageItem('vn');
            if($this->updatePageItem($enItem) && $this->updatePageItem($vnItem)) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * This function makes a call to the database to update a page item
     * @param $pageItem
     * @return bool
     */
    private function updatePageItem($pageItem)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE page_item
            SET page_position = ?, heading = ?, content = ?, edited_at = ?, tag = ?
            WHERE id = ?
            AND page_id = ?'
        );

        $stmt->bind_param('issssii', $pageItem->pagePosition, $pageItem->heading, $pageItem->content,
            $pageItem->editedAt, $pageItem->tag, $pageItem->id, $pageItem->pageId);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function checks to see if all variables in a page item are valid
     * @return bool
     */
    private function pageItemValidationCheck()
    {
        $check = true;

        if (!$this->checkValidationInt($this->pageItem->pageId)) {
            $check = false;
        }
        if (!$this->checkValidationInt($this->pageItem->enItemId)) {
            $check = false;
        }
        if (!$this->checkValidationInt($this->pageItem->vnItemId)) {
            $check = false;
        }
        if (!$this->checkValidationInt($this->pageItem->pagePosition)) {
            $check = false;
        }
        if (!$this->checkValidationString($this->pageItem->enHeading)) {
            $check = false;
        }
        if (!$this->checkValidationString($this->pageItem->vnHeading)) {
            $check = false;
        }
        if (!$this->checkValidationString($this->pageItem->enContent)) {
            $check = false;
        }
        if (!$this->checkValidationString($this->pageItem->vnContent)) {
            $check = false;
        }
        if (!$this->checkValidationString($this->pageItem->tag)) {
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks to see if a variable is a valid integer
     * @param $input
     * @return bool
     */
    private function checkValidationInt($input)
    {
        return isset($input) && is_int($input) && $input > 0;
    }

    /**
     * This function checks to see if a variable is a valid string
     * @param $input
     * @return bool
     */
    private function checkValidationString($input)
    {
        return isset($input) && is_string($input) && strlen($input) > 0;
    }

    /**
     * This function makes a page item object
     * @param $lang
     * @return stdClass
     */
    private function createTempPageItem($lang)
    {
        $tempItem = new stdClass();
        if ($lang === 'en') {
            $tempItem->pageId = $this->pageItem->pageId;
            $tempItem->id = $this->pageItem->enItemId;
            $tempItem->heading = $this->pageItem->enHeading;
            $tempItem->content = $this->pageItem->enContent;
            $tempItem->tag = $this->pageItem->tag;
            $tempItem->pagePosition = $this->pageItem->pagePosition;
            $tempItem->createdAt = $this->pageItem->createdAt;
        } elseif ($lang === 'vn') {
            $tempItem->pageId = $this->pageItem->pageId;
            $tempItem->id = $this->pageItem->vnItemId;
            $tempItem->heading = $this->pageItem->vnHeading;
            $tempItem->content = $this->pageItem->vnContent;
            $tempItem->tag = $this->pageItem->tag;
            $tempItem->pagePosition = $this->pageItem->pagePosition;
            $tempItem->createdAt = $this->pageItem->createdAt;
        }
        $tempItem->editedAt = date('Y-m-d H:i:s');
        $tempItem->language = $lang;
        return $tempItem;
    }

    /**
     * @return bool
     */
    private function updatePagePosition()
    {
        $results = array();
        $postParams = $this->pageItems;
        if (count($postParams) < 2) {
            $check = false;
        } else {
            foreach ($postParams as $postParam) {
                if (isset($postParam->imgUrl)) {
                    //Update image object
                    $results[] = $this->updateImageItemPosition($postParam);
                } else {
                    //Update page item object
                    $results[] = $this->prepPageItemPositionUpdate($postParam);
                }
            }
            $check = $this->checkResults($results);
        }

        return $check;
    }

    /**
     * This function checks to see all updates were made correctly
     * @param $results
     * @return bool
     */
    private function checkResults($results)
    {
        $success = true;
        foreach ($results as $result) {
            if ($result === false) {
                $success = false;
                break;
            }
        }
        return $success;
    }

    private function prepPageItemPositionUpdate($pageItem)
    {
        $result = false;
        if (isset($pageItem->pagePosition, $pageItem->enItemId, $pageItem->vnItemId, $pageItem->pageId)) {
            $result = $this->updatePageItemPosition($pageItem->pagePosition, $pageItem->enItemId, $pageItem->pageId)
                && $this->updatePageItemPosition($pageItem->pagePosition, $pageItem->vnItemId, $pageItem->pageId);
        }
        return $result;
    }

    /**
     * This function updates a page item's page position
     * @param $pagePosition
     * @param $itemId
     * @param $pageId
     * @return bool
     */
    private function updatePageItemPosition($pagePosition, $itemId, $pageId)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE page_item
            SET page_position = ?
            WHERE id = ?
            AND page_id = ?'
        );

        $stmt->bind_param('iii', $pagePosition, $itemId, $pageId);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function updates a page image's page position
     * @param $imageItem
     * @return bool
     */
    private function updateImageItemPosition($imageItem)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'UPDATE image_details 
            SET page_position = ? 
            WHERE id = ? 
            AND page_id = ?'
        );

        $stmt->bind_param('iii', $imageItem->pagePosition, $imageItem->id, $imageItem->pageId);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }
}