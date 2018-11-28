<?php

class EditPageItems extends ConnectDb
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

    public function receivePostRequestData() {
        $results = $this->checkParams();
        return $results;
    }

    private function checkParams() {
        if(count(json_decode($_POST['pageItems'])) < 2) {
            return false;
        } else {
            return $this->processPageItems();
        }
    }

    private function processPageItems() {
        $successCheck = true;
        $pageItems = json_decode($_POST['pageItems']);

        foreach($pageItems as $pageItem) {
            if(isset($pageItem->id)) {
                $successCheck = $this->processPageImage($pageItem);
            } else {
                $successCheck = $this->processPageItem($pageItem);
            }
        }
        return $successCheck;
    }

    private function processPageImage($pageImage){
        $oldPageImage = $this->getPageImage($pageImage);
        $changeCheck = $this->editPageImage($pageImage);
        $newPageImage = $this->getPageImage($pageImage);

        if($changeCheck) {
            return $oldPageImage['pagePosition'] !== $newPageImage['pagePosition'];
        }
        return false;
    }

    private function editPageImage($pageImage) {
        $stmt = $this->mysqli->prepare(
            'UPDATE tapout_image 
            SET page_position = ?
            WHERE id = ?'
        );

        $stmt->bind_param('ii', $pageImage->pagePosition, $pageImage->id);

        return $stmt->execute();
    }

    private function getPageImage($pageImage) {
        $stmt = $this->mysqli->prepare(
            'SELECT * FROM tapout_image
            WHERE id = ?'
        );

        $stmt->bind_param('i', $pageImage->id);

        $stmt->execute();

        $stmt->bind_result($id, $pageId, $imgUrl, $createdAt, $pagePosition);

        $stmt->fetch();

        return [
            'id' => $id,
            'pageId' => $pageId,
            'imgUrl' => $imgUrl,
            'pagePosition' => $pagePosition
        ];
    }

    private function processPageItem($pageItem) {
        $oldPageItem = $this->getPageItem($pageItem);
        $changeCheck = $this->editPageItem($pageItem);
        $newPageItem = $this->getPageItem($pageItem);
    }

    private function getPageItem($pageItem) {
        $enPageItem = $this->getPageItemByLanguage($pageItem);
    }

    //@todo not finished, decide how you want things to be edited

    //@todo option 1) Let the front end keep track of changes and then change everything in 1 go
    //@todo option 2) Edit things on the fly

    private function getPageItemByLanguage($pageItem) {
        $rawResults = [];

        $stmt = $this->mysqli->prepare(
            'SELECT id, page_id, edited_at, language, tag, page_position FROM tapout_page_item
            WHERE page_id = ?
            AND tag = ?
            AND id = ? OR id = ?'
        );

        $stmt->bind_param('isii',
            $pageItem->pageId,
            $pageItem->tag,
            $pageItem->enItemId,
            $pageItem->vnItemId);

        $stmt->execute();

        $stmt->bind_result($itemId, $pageId, $editedAt, $lang, $tag, $pagePosition);

        while($stmt->fetch()) {
            $rawResults[] = [
                'itemId' => $itemId,
                'pageId' => $pageId,
                'editedAt' => $editedAt,
                'lang' => $lang,
                'tag' => $tag,
                'pagePosition' => $pagePosition
            ];
        }

        return $this->sortPageItemRawResults($rawResults);
    }

    private function sortPageItemRawResults($rawResults) {
        $sortedResults = [];
        foreach($rawResults as $result) {
            if($result['lang'] === 'en') {
                $sortedResults['enItemId'] = $result['itemId'];
                $sortedResults['pagePosition'] = $result['pagePosition'];
                $sortedResults['tag'] = $result['tag'];
//                $sortedResults['']
            } else {

            }
        }
    }

    private function editPageItem($pageItem) {

    }
}