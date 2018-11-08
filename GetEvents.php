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
            $categories = $this->languageCheck();
            $results = $this->getItems($categories);
        }
        return $results;
    }

    private function getItems($categories) {
        $tomorrowTimestamp = $this->getTomorrowsDate();

        $results = array();
        $count = 0;

        foreach ($categories as $category) {
            //Unique items
            if($category['categoryType'] === 'unique') {
                $category['categoryItems'] = $this->getTypeUnqiue($category['categoryId'], $tomorrowTimestamp);
            } else {
                $category['categoryItems'] = $this->getOtherCategories($category['categoryId']);
            }

            if(count($category['categoryItems']) !== 0) {
                $results['category'][$count] = $category;

            }

            $count++;
        }
        return $results;
    }

    private function getTomorrowsDate() {
        $dateCriteria = new dateTime('+1 day');
        return $dateCriteria->getTimestamp();
    }

    private function getOtherCategories($requestCategoryId) {
        $items = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, category_id, heading, description, start_time, end_time,
            start_date, category_position
            FROM tapout_event_item
            WHERE category_id = ?
            ORDER BY category_position ASC'
        );

        $stmt->bind_param('i', $requestCategoryId);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $startTime, $endTime, $startDate, $categoryPosition);

        while($stmt->fetch()) {
            $items[] = [
                'itemId' => $id,
                'categoryId' => $categoryId,
                'itemHeading' => $heading,
                'itemDescription' => $description,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'startDate' => $startDate,
                'categoryPosition' => $categoryPosition
            ];
        }

        return $items;
    }

    private function getTypeUnqiue($requestCategoryId, $dateCriteria) {
        $items = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, category_id, heading, description, start_time, end_time, 
            start_date, category_position
            FROM tapout_event_item
            WHERE category_id = ?
            AND start_date > ?
            ORDER BY category_position ASC'
        );

        $stmt->bind_param('ii', $requestCategoryId, $dateCriteria);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $startTime, $endTime, $startDate, $categoryPosition);

        while($stmt->fetch()) {
            $items[] = [
                'itemId' => $id,
                'categoryId' => $categoryId,
                'itemHeading' => $heading,
                'itemDescription' => $description,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'startDate' => $startDate,
                'categoryPosition' => $categoryPosition
            ];
        }

        return $items;
    }


    private function checkParams() {
        if(isset($_GET['page']) && $_GET['page'] === 'Events' && isset($_GET['lang'])
            && ($_GET['lang'] === 'en' || $_GET['lang'] === 'vn')) {
            return true;
        } else {
            return false;
        }
    }

    private function getCategories($lang) {
        /**
         * Get categories by type (weekly, unique etc)
         * Get items
         */

        $categories = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, name, type, language, page_position
                FROM tapout_event_category AS t_e_category
                WHERE active = 1
                AND language = ?
                ORDER BY page_position ASC'
        );

        $stmt->bind_param('s', $lang);

        $stmt->execute();

        $stmt->bind_result($id, $name, $type, $language, $pagePosition);

        while($stmt->fetch()) {
            $categories[] = [
                'categoryId' => $id,
                'categoryName' => $name,
                'categoryType' => $type,
                'language' => $language,
                'pagePosition' => $pagePosition,
                'categoryItems' => []
                ];
        }

        return $categories;
    }

    private function languageCheck() {
        $lang = $_GET['lang'];

        return $this->getCategories($lang);
    }

}