<?php

/**
 * Created by PhpStorm.
 * User: J-Lap2
 * Date: 11/14/2018
 * Time: 7:29 PM
 */
class GetPageToEdit extends ConnectDb
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
     * This function communicates with the php file
     * @return array|null
     */
    public function pageCall() {
        $results = null;
        if($this->checkParams()) {
            $results = $this->organizeCall();
        }
        return $results;
    }

    /**
     * This function calls several functions to get data and sort it
     * @return array
     */
    private function organizeCall()
    {
        $pageId = $this->getPageId();
        $results['items'] = $this->getEditPageData($pageId);
        $results['images'] = $this->getPageImages($pageId);
        $sortedResults = $this->sortResults($results);
        return $sortedResults;
    }

    /**
     * This function sorts page items and images in pagePosition ASC
     * @param $results
     * @return array
     */
    private function sortResults($results) {
        $sortedItems = $this->sortItemsByTag($results['items']);
        foreach ($results['images'] as $image) {
            $sortedItems[]= $image;
        }
        usort($sortedItems, function($a, $b) {
            return $a['pagePosition'] <=> $b['pagePosition'];
        });

        return $sortedItems;
    }

    /**
     * This function sorts page items by tag
     * @param $pageItems
     * @return array
     */
    private function sortItemsByTag($pageItems) {
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
     * This function checks that all the $_GET parameters are correct
     * @return bool
     */
    private function checkParams() {
        if(isset($_GET['task']) && $_GET['task'] === 'Edit' && isset($_GET['page']) && $this->checkPageRequest()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function checks that $_GET['page'] matches an existing page
     * @return bool
     */
    private function checkPageRequest() {
        $pageNames = array();

        $stmt = $this->mysqli->prepare(
            'SELECT name FROM tapout_page'
        );

        $stmt->execute();

        $stmt->bind_result($name);

        while($stmt->fetch()) {
            $pageNames[] = $name;
        }

        if(in_array($_GET['page'], $pageNames)) {
            return true;
        } else {
            return false;
        }
    }



    /**
     * This function gets all page data for it to be edited
     * @param $pageId
     * @return array
     */
    private function getEditPageData($pageId)
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
     * This function gets all image URLS with a given page_id
     * @param $pageId
     * @return array
     */
    private function getPageImages($pageId) {
        $results = array();

        $stmt = $this->mysqli->prepare('SELECT * FROM tapout_image WHERE page_id = ?');

        $stmt->bind_param('i', $pageId);

        $stmt->execute();

        $stmt->bind_result($id, $pageId, $imgUrl, $createdAt, $pagePosition);

        while($stmt->fetch()) {
            $results[] = [
                'id' => $id,
                'pageId' => $pageId,
                'imgUrl' => $imgUrl,
                'createdAt' => $createdAt,
                'pagePosition' => $pagePosition
            ];
        }

        return $results;
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
}