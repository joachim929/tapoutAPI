<?php

require_once('../ConnectDb.php');

class ReadMenu extends ConnectDb
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
     * This function checks the $_GET params and calls functions depending on the params
     * @return array|null
     */
    private function checkParams()
    {
        $results = null;
        if (isset($_GET['page'], $_GET['task']) && $_GET['page'] === 'menu') {
            //Case for user web page
            if (isset($_GET['lang']) && $_GET['task'] === 'read' &&
                ($_GET['lang'] === 'en' || $_GET['lang'] === 'vn')
            ) {
                $results = $this->getMenu();
            }
            //Case for editing web page
            if (!isset($_GET['lang']) && $_GET['task'] === 'edit') {
                $results = $this->getMenuToEdit();
            }
        }
        return $results;
    }

    /**
     * This function calls all functions needed to get data with given parameters
     * @return array|null
     */
    private function getMenu()
    {
        $rawResults = $this->fetchMenuDataByLanguage($_GET['lang']);
        $sortedRawResults = $this->sortRawData($rawResults);
        return $this->sortMenuResults($sortedRawResults);
    }

    /**
     * This function sorts menu item results into categories
     * @param $results
     * @return array
     */
    private function sortRawData($results) {
        $sortedCategories = array();

        foreach ($results as $result) {
            $itemArray = [
                'id' => $result['id'],
                'title' => $result['title'],
                'price' => $result['price'],
                'description' => $result['description'],
                'categoryPosition' => $result['categoryPosition'],
                'itemTag' => $result['itemTag']
            ];
            if(!isset($sortedCategories[$result['categoryId']])){
                $sortedCategories[$result['categoryId']] = [
                    'id' => $result['categoryId'],
                    'pagePosition' => $result['pagePosition'],
                    'name' => $result['categoryName'],
                    'categoryTag' => $result['categoryTag'],
                    'items' => [ $itemArray ]
                ];
            } else {
                $sortedCategories[$result['categoryId']]['items'][] = $itemArray;
            }
        }

        return $sortedCategories;
    }

    /**
     * This function fetches menu item data by language
     * @param $language
     * @return array
     */
    private function fetchMenuDataByLanguage($language)
    {
        $results = array();

        $stmt = $this->mysqli->prepare('SELECT item.*, category.name, category.page_position, category.tag 
        FROM tapout_menu_item 
        AS item 
        LEFT JOIN tapout_menu_category 
        AS category 
        ON item.category_id = category.id 
        WHERE category.language = ?');

        $stmt->bind_param('s', $language);

        $stmt->execute();

        $stmt->bind_result($itemId, $categoryId, $title, $price, $description, $categoryPosition,
            $itemTag, $language, $categoryName, $pagePosition, $categoryTag);

        while ($stmt->fetch()) {
            $results[] = [
                'id' => $itemId,
                'categoryId' => $categoryId,
                'title' => $title,
                'price' => $price,
                'description' => $description,
                'categoryPosition' => $categoryPosition,
                'itemTag' => $itemTag,
                'categoryName' => $categoryName,
                'pagePosition' => $pagePosition,
                'categoryTag' => $categoryTag
            ];
        }

        $stmt->close();
        return $results;
    }

    /**
     * This function calls other functions that gets and returns data in the required structure
     * @return array|null
     */
    private function getMenuToEdit()
    {
        $rawResults = $this->fetchMenuData();
        $categoryTags = $this->getCategoryTags();
        $matchedResultsAndCategories = $this->matchResultsWithCategoryTags($rawResults, $categoryTags);
        $sortedResults = $this->sortMenuResults($matchedResultsAndCategories);
        return $sortedResults;
    }

    /**
     * This function gets all distinct menu category tags and returns an array with null values
     * @return array
     */
    public function getCategoryTags()
    {
        $categoryTags = array();

        $stmt = $this->mysqli->prepare('SELECT DISTINCT tag FROM tapout_menu_category');

        $stmt->execute();

        $stmt->bind_result($tag);

        while ($stmt->fetch()) {
            $categoryTags[$tag] = [
                'categoryTag' => null,
                'enCategoryId' => null,
                'vnCategoryId' => null,
                'pagePosition' => null,
                'enCategoryName' => null,
                'vnCategoryName' => null,
                'categoryType' => null,
                'items' => array()
            ];
        }

        $stmt->close();
        return $categoryTags;
    }

    /**
     * This function fetches menu item data
     * @return array
     */
    private function fetchMenuData()
    {
        $results = array();

        $stmt = $this->mysqli->prepare('
        SELECT item.*, category.name, category.page_position, category.tag, category.language, category.type 
        FROM tapout_menu_item 
        AS item 
        LEFT JOIN tapout_menu_category 
        AS category 
        ON item.category_id = category.id');

        $stmt->execute();

        $stmt->bind_result($itemId, $categoryId, $title, $price, $description, $categoryPosition,
            $itemTag, $itemLanguage, $categoryName, $pagePosition, $categoryTag, $categoryLanguage, $categoryType);

        while ($stmt->fetch()) {
            $results[] = [
                'id' => $itemId,
                'categoryId' => $categoryId,
                'title' => $title,
                'price' => $price,
                'description' => $description,
                'categoryPosition' => $categoryPosition,
                'itemTag' => $itemTag,
                'itemLanguage' => $itemLanguage,
                'categoryName' => $categoryName,
                'pagePosition' => $pagePosition,
                'categoryTag' => $categoryTag,
                'categoryLanguage' => $categoryLanguage,
                'categoryType' => $categoryType
            ];
        }

        $stmt->close();
        return $results;
    }

    /**
     * This function matches menu item data with categories, combing data for both languages
     * @param $results
     * @param $categoryTags
     * @return array
     */
    private function matchResultsWithCategoryTags($results, $categoryTags)
    {
        $sortedResults = array();
        foreach ($results as $result) {
            $tag = $result['categoryTag'];
            if ($result['categoryLanguage'] === 'en') {
                $categoryTags[$tag]['categoryTag'] = $result['categoryTag'];
                $categoryTags[$tag]['enCategoryId'] = $result['categoryId'];
                $categoryTags[$tag]['pagePosition'] = $result['pagePosition'];
                $categoryTags[$tag]['enCategoryName'] = $result['categoryName'];
                $categoryTags[$tag]['categoryType'] = $result['categoryType'];
                $categoryTags[$tag]['items'][$result['itemTag']]['vnItemId'] = $result['id'];
                $categoryTags[$tag]['items'][$result['itemTag']]['vnTitle'] = $result['title'];
                $categoryTags[$tag]['items'][$result['itemTag']]['vnDescription'] = $result['description'];
                $categoryTags[$tag]['items'][$result['itemTag']]['price'] = $result['price'];
                $categoryTags[$tag]['items'][$result['itemTag']]['categoryPosition'] = $result['categoryPosition'];
                $categoryTags[$tag]['items'][$result['itemTag']]['itemTag'] = $result['itemTag'];
            } else {
                $categoryTags[$tag]['categoryTag'] = $result['categoryTag'];
                $categoryTags[$tag]['vnCategoryId'] = $result['categoryId'];
                $categoryTags[$tag]['pagePosition'] = $result['pagePosition'];
                $categoryTags[$tag]['vnCategoryName'] = $result['categoryName'];
                $categoryTags[$tag]['categoryType'] = $result['categoryType'];
                $categoryTags[$tag]['items'][$result['itemTag']]['enItemId'] = $result['id'];
                $categoryTags[$tag]['items'][$result['itemTag']]['enTitle'] = $result['title'];
                $categoryTags[$tag]['items'][$result['itemTag']]['enDescription'] = $result['description'];
                $categoryTags[$tag]['items'][$result['itemTag']]['price'] = $result['price'];
                $categoryTags[$tag]['items'][$result['itemTag']]['categoryPosition'] = $result['categoryPosition'];
                $categoryTags[$tag]['items'][$result['itemTag']]['itemTag'] = $result['itemTag'];
            }
        }

        foreach ($categoryTags as $categoryTag) {
            $sortedCategory = array();
            foreach ($categoryTag['items'] as $item) {
                $sortedCategory[] = $item;
            }
            $categoryTag['items'] = $sortedCategory;
            $sortedResults[] = $categoryTag;
        }

        return $sortedResults;
    }

    /**
     * This function sorts menu items by category position and categories by page position
     * @param $sortedResults
     * @return mixed
     */
    private function sortMenuResults($sortedResults)
    {
        foreach ($sortedResults as $key => $sortedResult) {
            usort($sortedResult['items'], array('ReadMenu', 'comparisonCategoryPosition'));
            $sortedResults[$key] = $sortedResult;
        }
        usort($sortedResults, array('ReadMenu', 'comparisonPagePosition'));
        return $sortedResults;
    }

    private function comparisonCategoryPosition($a, $b)
    {
        if ($a['categoryPosition'] === $b['categoryPosition']) {
            return 0;
        }
        return ($a['categoryPosition'] < $b['categoryPosition']) ? -1 : 1;
    }

    private function comparisonPagePosition($a, $b)
    {
        if ($a['pagePosition'] === $b['pagePosition']) {
            return 0;
        }
        return ($a['pagePosition'] < $b['pagePosition']) ? -1 : 1;
    }
}