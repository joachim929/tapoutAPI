<?php

/**
 * Created by PhpStorm.
 * User: J-Lap2
 * Date: 11/7/2018
 * Time: 8:09 PM
 */
class GetEvents extends ConnectDb
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

    function closeConn()
    {
        $this->conn = null;
    }

    public function eventsCall() {
        $results = null;
        if($this->checkParams()) {
            $results = $this->prepForCall();
        }
        return $results;
    }

    private function checkParams() {
        if(isset($_GET['page']) && $_GET['page'] === 'Events' && isset($_GET['lang'])
            && ($_GET['lang'] === 'en' || $_GET['lang'] === 'vn')) {
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

    private function prepForCall() {
        /**
         * Get calls a month in advance,
         * 2)If events aren't unique grab all of them, then check to see if they are happening
         *  - within a month of current date/time
         * 3)Grab all unique events that haven't been and gone
         */
        $categoryResults = $this->getCategories();
        return $this->sortCategories($categoryResults);


        $nowDate = new DateTime();
        $nowDate->modify('+1 day');
        $nowDate = $nowDate->getTimestamp();

        $nowTime = time();

        $results = array();

        $stmt = $this->mysqli->prepare(
            'SELECT t_e_item.*, t_e_category.name, t_e_category.tag,                     t_e_category.language
                    FROM tapout_event_item AS t_e_item
                    LEFT JOIN tapout_event_category AS t_e_category
                    ON t_e_category.id = t_e_item.category_id
                    WHERE t_e_category.active = 1
                    AND t_e_item.start_date >= ?
                    '
        );

        $stmt->bind_param('i', $nowDate);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $lang, $tag, $startTime,
            $endTime, $createdAt, $startDate, $editedAt, $categoryPosition,
            $categoryName, $categoryTag, $categoryLang);

        while ($stmt->fetch()) {
            $results[] = [
                'id' => $id,
                'categoryId' => $categoryId,
                'heading' => $heading,
                'description' => $description,
                'lang' => $lang,
                'tag' => $tag,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'startDate' => $startDate,
                'categoryPosition' => $categoryPosition,
                'categoryName' => $categoryName,
                'categoryTag' => $categoryTag,
                'categoryLang' => $categoryLang
            ];
        }

        $stmt->close();
        return $results;
    }

}