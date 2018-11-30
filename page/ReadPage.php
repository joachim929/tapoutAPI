<?php
require_once '../ConnectDb.php';

class ReadPage extends ConnectDb
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
        $results = $this->checkParams();
        if ($results !== []) {
            echo json_encode((array)$results);
        } else {
            echo json_encode(null);
        }
    }

    /**
     * This function checks the 'base' params to see if they are correct
     * @return array
     */
    private function checkParams()
    {
        $results = array();
        if (isset($_GET['page'], $_GET['task']) && ($_GET['page'] === 'Home' || $_GET['page'] === 'About'
                || $_GET['page'] === 'Contact' || $_GET['page'] === 'Gallery')
        ) {
            $results = $this->checkTask();
        }
        return $results;
    }

    /**
     * This function checks given params further to determine what data to attempt to get and return
     * @return array
     */
    private function checkTask()
    {
        $pageId = $this->getPageId();
        $results = array();
        //Case for user webpage
        if ($_GET['task'] === 'read' && isset($_GET['lang']) &&
            ($_GET['lang'] === 'en' || $_GET['lang'] === 'vn')
        ) {
            $results = $this->getEvents($pageId);
        } //Case for items to edit
        // @todo: need to check if authentication is good
        elseif ($_GET['task'] === 'edit' && !isset($_GET['lang'])) {
            $results = $this->cGetEvents($pageId);
        }
        return $results;
    }

    /**
     * This function makes the calls to get all the data for a page for normal users
     * @param $pageId
     * @return array
     */
    private function getEvents($pageId)
    {
        $results = array();
        if ($pageId !== null) {
            $pageItems = $this->getPageItems($pageId);
            $results = $this->getPageImages($pageId, $pageItems);
            usort($results, array('ReadPage', 'comparisonPagePosition'));
        }
        // @todo: sort page images and items by page position
        return $results;
    }

    private function cGetEvents($pageId)
    {
        $pageItems = $this->getAllPageItems($pageId);
        $pageImages = $this->getPageImages($pageId);
        $sortedPageItems = $this->sortPageItems($pageItems);
        return $this->sortResults($sortedPageItems, $pageImages);
    }

    private function sortResults($pageItems, $pageImages)
    {
        $sortedResults = $pageItems;
        foreach($pageImages as $image) {
            $sortedResults[] = $image;
        }
        usort($sortedResults, array('ReadPage', 'comparisonPagePosition'));

        return $sortedResults;
    }


    private function sortPageItems($pageItems)
    {
        $sortedItems = array();

        foreach ($pageItems as $pageItem) {
            if(isset($sortedItems[$pageItem['tag']])) {
                $sortedItems[$pageItem['tag']] = $this->setPageItem($pageItem, $sortedItems[$pageItem['tag']]);
            } else {
                $sortedItems[$pageItem['tag']] = $this->setPageItem($pageItem);
            }
        }

        return $this->removeArrayKeys($sortedItems);
    }

    /**
     * This function removes array keys and returns said array
     * @param $array
     * @return array
     */
    private function removeArrayKeys($array) {
        $noKeysArray = array();

        foreach ($array as $item) {
            $noKeysArray[] = $item;
        }

        return $noKeysArray;
    }

    /**
     * This function merges en and vn page items into one
     * @param $pageItem
     * @param null $sortedItem
     * @return array|null
     */
    private function setPageItem($pageItem, $sortedItem = null) {
        if($pageItem['language'] === 'en') {
            $sortedItem['pageId'] = $pageItem['pageId'];
            $sortedItem['enItemId'] = $pageItem['itemId'];
            $sortedItem['enHeading'] = $pageItem['heading'];
            $sortedItem['enContent'] = $pageItem['content'];
            $sortedItem['tag'] = $pageItem['tag'];
            $sortedItem['pagePosition'] = $pageItem['pagePosition'];
            $sortedItem['createdAt'] = $pageItem['createdAt'];
            $sortedItem['editedAt'] = $pageItem['editedAt'];
        } else {
            $sortedItem['pageId'] = $pageItem['pageId'];
            $sortedItem['vnItemId'] = $pageItem['itemId'];
            $sortedItem['vnHeading'] = $pageItem['heading'];
            $sortedItem['vnContent'] = $pageItem['content'];
            $sortedItem['tag'] = $pageItem['tag'];
            $sortedItem['pagePosition'] = $pageItem['pagePosition'];
            $sortedItem['createdAt'] = $pageItem['createdAt'];
            $sortedItem['editedAt'] = $pageItem['editedAt'];
        }

        return $sortedItem;
    }

    /**
     * This function finds a page id with a given page name
     * @return int|null
     */
    private function getPageId()
    {
        $page = $_GET['page'];

        $stmt = $this->mysqli->prepare('SELECT id FROM tapout_page WHERE name = ?');

        $stmt->bind_param('s', $page);

        $stmt->execute();

        $stmt->bind_result($pageId);

        $stmt->fetch();

        $stmt->close();

        return $pageId;
    }

    /**
     * This function finds all page items with a given page id
     * @param $pageId
     * @return array
     */
    private function getPageItems($pageId)
    {
        $rawData = array();
        $language = $_GET['lang'];

        $stmt = $this->mysqli->prepare('SELECT id, page_id, heading, content, created_at, edited_at, page_position 
        FROM tapout_page_item 
        WHERE language = ? 
        AND page_id = ?
        ORDER BY page_position ASC');

        $stmt->bind_param('si', $language, $pageId);

        $stmt->execute();

        $stmt->bind_result($id, $pageId, $heading, $content, $createdAt, $editedAt, $pagePosition);

        while ($stmt->fetch()) {
            $rawData[] = [
                'id' => $id,
                'pageId' => $pageId,
                'heading' => $heading,
                'content' => $content,
                'createdAt' => $createdAt,
                'editedAt' => $editedAt,
                'pagePosition' => $pagePosition
            ];
        }

        $stmt->close();
        return $rawData;
    }

    private function getAllPageItems($pageId)
    {
        $result = array();

        $stmt = $this->mysqli->prepare('SELECT * FROM tapout_page_item WHERE page_id = ?');

        $stmt->bind_param('s', $pageId);

        $stmt->execute();

        $stmt->bind_result($itemId, $pageId, $heading, $content, $createdAt, $editedAt, $language, $tag, $pagePosition);

        while($stmt->fetch()){
            $result[] = [
                'itemId' => $itemId,
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

        $stmt->close();
        return $result;
    }

    /**
     * This function finds all page images with a given page id and adds it to the page items results
     * @param $pageId
     * @param $pageItems
     * @return array
     */
    private function getPageImages($pageId, $pageItems = [])
    {
        $stmt = $this->mysqli->prepare('SELECT * FROM tapout_image WHERE page_id = ?');

        $stmt->bind_param('i', $pageId);

        $stmt->execute();

        $stmt->bind_result($id, $pageId, $imgUrl, $createdAt, $pagePosition);

        while ($stmt->fetch()) {
            $pageItems[] = [
                'id' => $id,
                'pageId' => $pageId,
                'imgUrl' => $imgUrl,
                'createdAt' => $createdAt,
                'pagePosition' => $pagePosition
            ];
        }

        return $pageItems;
    }

    private function comparisonPagePosition($a, $b)
    {
        if ($a['pagePosition'] === $b['pagePosition']) {
            return 0;
        }
        return ($a['pagePosition'] < $b['pagePosition']) ? -1 : 1;
    }
}