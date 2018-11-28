<?php

class GetEventsToEdit extends ConnectDb
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

    public function eventsCall() {
        $results = null;
        if($this->checkParams()) {
            $results = $this->prepForCall();
        }
        return $results;
    }

    private function checkParams() {
        if(isset($_GET['page']) && $_GET['page'] === 'Events' && isset($_GET['task'])
            && ($_GET['task'] === 'Edit')) {
            return true;
        } else {
            return false;
        }
    }

    private function getCategories() {
        $categories = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, name, type, language, tag, page_position
                FROM tapout_event_category
                WHERE active = 1
                ORDER BY page_position ASC'
        );

        $stmt->execute();

        $stmt->bind_result($id, $name, $type, $lang, $tag, $pagePosition);

        while($stmt->fetch()) {
            $categories[] = [
                'categoryId' => $id,
                'categoryName' => $name,
                'categoryType' => $type,
                'lang' => $lang,
                'tag' => $tag,
                'pagePosition' => $pagePosition
            ];
        }

        return $categories;
    }

    private function sortCategories($catResults) {
        $matchedCats = array();

        foreach ($catResults as $catResult) {
            if(!isset($matchedCats[$catResult['tag']])) {
                $matchedCats[$catResult['tag']]['tag'] = $catResult['tag'];
                $matchedCats[$catResult['tag']]['type'] = $catResult['categoryType'];
                $matchedCats[$catResult['tag']]['pagePosition'] = $catResult['pagePosition'];
            }

            if($catResult['lang'] === 'en') {
                $matchedCats[$catResult['tag']]['enCatId'] = $catResult['categoryId'];
                $matchedCats[$catResult['tag']]['enCatName'] = $catResult['categoryName'];
                $matchedCats[$catResult['tag']]['enEventItems'] = array();
            } else {
                $matchedCats[$catResult['tag']]['vnCatId'] = $catResult['categoryId'];
                $matchedCats[$catResult['tag']]['vnCatName'] = $catResult['categoryName'];
                $matchedCats[$catResult['tag']]['vnEventItems'] = array();
            }
        }
        return $this->formatMatchedCategories($matchedCats);
    }

    private function formatMatchedCategories($matchedCategories) {
        $formattedCategories = array();

        foreach($matchedCategories as $matCat) {
            $formattedCategories['categories'][] = $matCat;
        }

        return $formattedCategories;
    }

    private function getWeeklyCategoryItems($category) {
        if(isset($category['enCatId']) && isset($category['vnCatId'])) {
            $category['enEventItems'] = $this->getWeeklyItems($category['enCatId']);
            $category['vnEventItems'] = $this->getWeeklyItems($category['vnCatId']);
        }

        return $category;
    }

    private function getUniqueCategoryItems($category, $dateCheck) {
        if(isset($category['enCatId']) && isset($category['vnCatId'])) {
            $category['enEventItems'] = $this->getUnqiueItems($category['enCatId'], $dateCheck);
            $category['vnEventItems'] = $this->getUnqiueItems($category['vnCatId'], $dateCheck);
        }

        return $category;
    }


    private function getWeeklyItems($categoryId) {
        $categoryItems = array();

        $stmt = $this->mysqli->prepare(
            'SELECT * FROM tapout_event_item
                    WHERE category_id = ?
                    ORDER BY category_position ASC'
        );

        $stmt->bind_param('i', $categoryId);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $language, $tag, $startTime, $endTime, $createdAt, $startDate, $editedAt, $categoryPosition);

        while($stmt->fetch()) {
            $categoryItems[] = [
                'itemId' => $id,
                'itemHeading' => $heading,
                'itemDescription' => $description,
                'itemTag' => $tag,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'createdAt' => $createdAt,
                'startDate' => $startDate,
                'editedAt' => $editedAt,
                'categoryPosition' => $categoryPosition
            ];
        }

        return $categoryItems;
    }

    private function getUnqiueItems($categoryId, $dateCheck) {
        $categoryItems = array();

        $stmt = $this->mysqli->prepare(
            'SELECT * FROM tapout_event_item
                    WHERE category_id = ?
                    AND start_date > ?
                    ORDER BY category_position ASC'
        );

        $stmt->bind_param('ii', $categoryId, $dateCheck);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $language, $tag, $startTime, $endTime, $createdAt, $startDate, $editedAt, $categoryPosition);

        while($stmt->fetch()) {
            $categoryItems[] = [
                'itemId' => $id,
                'itemHeading' => $heading,
                'itemDescription' => $description,
                'itemTag' => $tag,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'createdAt' => $createdAt,
                'startDate' => $startDate,
                'editedAt' => $editedAt,
                'categoryPosition' => $categoryPosition
            ];
        }

        return $categoryItems;
    }

    private function checkCategory($category, $dateCheck) {
        $populatedCategories = array();

        if($category['type'] === 'weekly') {
            $populatedCategories = $this->getWeeklyCategoryItems($category);
        } elseif ($category['type'] === 'unique') {
            $populatedCategories = $this->getUniqueCategoryItems($category, $dateCheck);
        } else {
            $populatedCategories[] = 'Whoops, something went wrong, no useable category type found';
        }

        return $populatedCategories;
    }


    private function prepForCall() {
        $categoryResults = $this->getCategories();
        $sortedCategories = $this->sortCategories($categoryResults);

        $dateCheck = new DateTime('-1 day');
        $dateCheck = $dateCheck->getTimestamp();

        foreach ($sortedCategories['categories'] as $key => $sortedCategory) {
            $sortedCategories['categories'][$key] = $this->checkCategory($sortedCategory, $dateCheck);
        }

        return $sortedCategories;
    }

    function closeConn()
    {
        $this->conn = null;
    }
}