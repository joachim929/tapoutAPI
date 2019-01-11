<?php
require_once('../ConnectDb.php');

class ReadEvent
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
        $results = $this->checkParams();

        if ($results !== []) {
            echo json_encode((array)$results);
        } else {
            echo json_encode(null);
        }
    }

    /**
     * This function checks the $_GET params and calls functions depending on the params
     * @return array|null
     */
    private function checkParams()
    {
        $results = null;
        if (isset($_GET['page'], $_GET['task']) && $_GET['page'] === 'Events') {
            //Case for user web page
            if (isset($_GET['lang']) && $_GET['task'] === 'read' &&
                ($_GET['lang'] === 'en' || $_GET['lang'] === 'vn')) {
                $results = $this->getEvents();
            }
            //Case for editing web page
            if (!isset($_GET['lang']) && $_GET['task'] === 'edit') {
                $results = $this->cGetEvents();
            }
        }
        return $results;
    }

    /**
     * This function passes on the requested language to other functions and returns data meant for the user page
     * @return array
     */
    private function getEvents()
    {
        $categories = $this->getCategoriesByLanguage($_GET['lang']);
        return $this->getEventItems($categories);
    }

    /**
     * This function calls all the necessary functions to get and return data meant for the edit page
     * @return array
     */
    private function cGetEvents()
    {
        $categoryResults = $this->getAllCategories();
        $sortedCategories = $this->sortAllCategories($categoryResults);
        $dateCheck = $this->getTomorrowsDate();

        foreach ($sortedCategories['categories'] as $key => $sortedCategory) {
            $sortedCategories['categories'][$key] = $this->checkCategory($sortedCategory, $dateCheck);
        }

        return $sortedCategories;
    }

    /**
     * This function gets all categories with a given language parameter
     * @param $lang
     * @return array
     */
    private function getCategoriesByLanguage($lang)
    {
        $categories = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, name, type, language, page_position
                FROM event_category AS t_e_category
                WHERE active = 1
                AND language = ?
                ORDER BY page_position ASC'
        );

        $stmt->bind_param('s', $lang);

        $stmt->execute();

        $stmt->bind_result($id, $name, $type, $language, $pagePosition);

        while ($stmt->fetch()) {
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

    /**
     * This function loops through all categories and call functions to get event items for those categories
     * @param $categories
     * @return array
     */
    private function getEventItems($categories)
    {
        $tomorrowTimestamp = $this->getTomorrowsDate();

        $results = array();
        $count = 0;

        foreach ($categories as $category) {
            //Unique items
            if ($category['categoryType'] === 'unique') {
                $category['categoryItems'] = $this->getTypeUnique($category['categoryId'], $tomorrowTimestamp);
            } else {
                $category['categoryItems'] = $this->getWeeklyCategories($category['categoryId']);
            }

            if (count($category['categoryItems']) !== 0) {
                $results['category'][$count] = $category;

            }

            $count++;
        }
        return $results;
    }

    /**
     * This function gets the unix timestamp for 24 hours from the time of being called,
     * This is done so that events are still shown before they are finished, and means I don't need to implement an end time
     * As I think there owner doesn't want to set an endtime/date
     * @return int
     */
    private function getTomorrowsDate()
    {
        $dateCriteria = new dateTime('+1 day');
        return $dateCriteria->getTimestamp();
    }

    /**
     * Gets all event items with a given category id that is a unique event (not reoccuring)
     * @param $requestCategoryId
     * @param $dateCriteria
     * @return array
     */
    private function getTypeUnique($requestCategoryId, $dateCriteria)
    {
        $items = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, category_id, heading, description, start_time, end_time, 
            start_date, category_position
            FROM event_item
            WHERE category_id = ?
            AND start_date > ?
            ORDER BY category_position ASC'
        );

        $stmt->bind_param('ii', $requestCategoryId, $dateCriteria);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $startTime, $endTime, $startDate, $categoryPosition);

        while ($stmt->fetch()) {
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

    /**
     * Gets all categories that reoccure on a weekly basis
     * @param $requestCategoryId
     * @return array
     */
    private function getWeeklyCategories($requestCategoryId)
    {
        $items = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, category_id, heading, description, start_time, end_time,
            start_date, category_position
            FROM event_item
            WHERE category_id = ?
            ORDER BY category_position ASC'
        );

        $stmt->bind_param('i', $requestCategoryId);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $startTime, $endTime, $startDate, $categoryPosition);

        while ($stmt->fetch()) {
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

    /**
     * Gets all active categories
     * @return array
     */
    private function getAllCategories()
    {
        $categories = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, name, type, language, tag, page_position
                FROM event_category
                WHERE active = 1
                ORDER BY page_position ASC'
        );

        $stmt->execute();

        $stmt->bind_result($id, $name, $type, $lang, $tag, $pagePosition);

        while ($stmt->fetch()) {
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

    /**
     * This function sorts all category results to contain both language types
     * @param $catResults
     * @return array
     */
    private function sortAllCategories($catResults)
    {
        $matchedCats = array();

        foreach ($catResults as $catResult) {
            if (!isset($matchedCats[$catResult['tag']])) {
                $matchedCats[$catResult['tag']]['tag'] = $catResult['tag'];
                $matchedCats[$catResult['tag']]['type'] = $catResult['categoryType'];
                $matchedCats[$catResult['tag']]['pagePosition'] = $catResult['pagePosition'];
                $matchedCats[$catResult['tag']]['eventItems'] = array();
            }

            if ($catResult['lang'] === 'en') {
                $matchedCats[$catResult['tag']]['enCatId'] = $catResult['categoryId'];
                $matchedCats[$catResult['tag']]['enCatName'] = $catResult['categoryName'];
            } else {
                $matchedCats[$catResult['tag']]['vnCatId'] = $catResult['categoryId'];
                $matchedCats[$catResult['tag']]['vnCatName'] = $catResult['categoryName'];

            }
        }
        return $this->formatMatchedCategories($matchedCats);
    }

    /**
     * This function removes key names and replaces them with incremental numbers
     * @param $matchedCategories
     * @return array
     */
    private function formatMatchedCategories($matchedCategories)
    {
        $formattedCategories = array();

        foreach ($matchedCategories as $matCat) {
            $formattedCategories['categories'][] = $matCat;
        }

        return $formattedCategories;
    }

    /**
     * This function checks what type of category it is and calls functions depending on the result
     * @param $category
     * @param $dateCheck
     * @return array
     */
    private function checkCategory($category, $dateCheck)
    {
        $populatedCategories = array();

        if ($category['type'] === 'weekly') {
            $populatedCategories = $this->getWeeklyCategoryItems($category);
        } elseif ($category['type'] === 'unique') {
            $populatedCategories = $this->getUniqueCategoryItems($category, $dateCheck);
        } else {
            $populatedCategories[] = 'Whoops, something went wrong, no useable category type found';
        }

        return $populatedCategories;
    }

    /**
     * This function gets all unique event items with given category ids
     * @param $enCatId
     * @param $vnCatId
     * @param $dateCheck
     * @return array
     */
    private function getUnqiueItems($enCatId, $vnCatId, $dateCheck)
    {
        $categoryItems = array();

        $stmt = $this->mysqli->prepare(
            'SELECT * FROM event_item
                    WHERE category_id = ?
                    OR category_id = ?
                    AND start_date > ?
                    ORDER BY category_position ASC'
        );

        $stmt->bind_param('iii', $enCatId, $vnCatId, $dateCheck);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $language, $tag, $startTime, $endTime, $createdAt, $startDate, $editedAt, $categoryPosition);

        while ($stmt->fetch()) {
            $categoryItems[] = [
                'itemId' => $id,
                'categoryId' => $categoryId,
                'itemHeading' => $heading,
                'itemDescription' => $description,
                'lang' => $language,
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

    /**
     * This function checks that it receives the correct category ids and then calls functions that
     * populates categories of type weekly
     * @param $category
     * @return mixed
     */
    private function getWeeklyCategoryItems($category)
    {
        if (isset($category['enCatId']) && isset($category['vnCatId'])) {
            $eventItems = $this->getWeeklyItems($category['enCatId'], $category['vnCatId']);
            $category['eventItems'] = $this->sortEventItemsByTags($eventItems);
        }

        return $category;
    }

    /**
     * This function checks that it receives the correct category ids and then calls functions that
     * populates categories of type unique
     * @param $category
     * @param $dateCheck
     * @return mixed
     */
    private function getUniqueCategoryItems($category, $dateCheck)
    {
        if (isset($category['enCatId']) && isset($category['vnCatId'])) {
            $eventItems = $this->getUnqiueItems($category['enCatId'], $category['vnCatId'], $dateCheck);
            $category['eventItems'] = $this->sortEventItemsByTags($eventItems);
        }

        return $category;
    }

    /**
     * This function sorts an array of event items so that events with tags are paired together and returns
     * a categories event items
     * @param $eventItems
     * @return array
     */
    private function sortEventItemsByTags($eventItems)
    {
        $pairedEventItems = array();

        foreach ($eventItems as $eventItem) {
            $pairedEventItems[$eventItem['itemTag']]['itemTag'] = $eventItem['itemTag'];
            $pairedEventItems[$eventItem['itemTag']]['startTime'] = $eventItem['startTime'];
            $pairedEventItems[$eventItem['itemTag']]['endTime'] = $eventItem['endTime'];
            $pairedEventItems[$eventItem['itemTag']]['createdAt'] = $eventItem['createdAt'];
            $pairedEventItems[$eventItem['itemTag']]['startDate'] = $eventItem['startDate'];
            $pairedEventItems[$eventItem['itemTag']]['editedAt'] = $eventItem['editedAt'];
            $pairedEventItems[$eventItem['itemTag']]['categoryPosition'] = $eventItem['categoryPosition'];

            if ($eventItem['lang'] === 'vn') {
                $pairedEventItems[$eventItem['itemTag']]['enItemId'] = $eventItem['itemId'];
                $pairedEventItems[$eventItem['itemTag']]['enCatId'] = $eventItem['categoryId'];
                $pairedEventItems[$eventItem['itemTag']]['enItemHeading'] = $eventItem['itemHeading'];
                $pairedEventItems[$eventItem['itemTag']]['enItemDescription'] = $eventItem['itemDescription'];
            } else {
                $pairedEventItems[$eventItem['itemTag']]['vnItemId'] = $eventItem['itemId'];
                $pairedEventItems[$eventItem['itemTag']]['vnCatId'] = $eventItem['categoryId'];
                $pairedEventItems[$eventItem['itemTag']]['vnItemHeading'] = $eventItem['itemHeading'];
                $pairedEventItems[$eventItem['itemTag']]['vnItemDescription'] = $eventItem['itemDescription'];
            }
        }

        // @todo: might still need to sort by category position, further testing needed
        $sortedEventItems = $this->formatEventItems($pairedEventItems);

        return $sortedEventItems;
    }

    /**
     * This function replaces key values with incremental numbers
     * @param $pairedEventItems
     * @return array
     */
    private function formatEventItems($pairedEventItems)
    {
        $eventItems = array();

        foreach ($pairedEventItems as $eventItem) {
            $eventItems[] = $eventItem;
        }

        return $eventItems;
    }

    /**
     * This function gets all weekly items with given category ids
     * @param $enCatId
     * @param $vnCatId
     * @return array
     */
    private function getWeeklyItems($enCatId, $vnCatId)
    {


        $categoryItems = array();

        $stmt = $this->mysqli->prepare(
            'SELECT * FROM event_item
                    WHERE category_id = ?
                    OR category_id = ?
                    ORDER BY category_position ASC'
        );

        $stmt->bind_param('ii', $enCatId, $vnCatId);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $language, $tag, $startTime, $endTime, $createdAt, $startDate, $editedAt, $categoryPosition);

        while ($stmt->fetch()) {
            $categoryItems[] = [
                'itemId' => $id,
                'categoryId' => $categoryId,
                'itemHeading' => $heading,
                'itemDescription' => $description,
                'lang' => $language,
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
}