<?php
require_once '../ConnectDb.php';

//Services
require_once '../Services/SortingService.php';

//Repos
require_once '../Repository/Menu/MenuRepository.php';

//Objects
require_once '../Objects/Menu/MenuItem.php';
require_once '../Objects/Menu/MenuCategory.php';
require_once './../Objects/Menu/BilingualMenuItem.php';
require_once './../Objects/Menu/BilingualMenuCategory.php';

class ReadMenu
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

    //Repos
    private $menuRepo;

    //Services
    private $sortingService;

    /**
     * @var null|string
     */
    private $language = null;

    function __construct()
    {
        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
        $this->menuRepo = new MenuRepository();
        $this->sortingService = new SortingService();
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
        if (isset($_GET['page'], $_GET['task']) && $_GET['page'] === 'Menu') {
            //Case for user web page
            if (isset($_GET['lang']) && $_GET['task'] === 'read' &&
                ($_GET['lang'] === 'en' || $_GET['lang'] === 'vn')
            ) {
                $this->language = $_GET['lang'];
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
        $rawResults = $this->menuRepo->getMenuByLanguage($this->language);
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
            $itemArray = new MenuItem($result['title'], $result['price'], $result['categoryPosition'],
                $result['id'], $result['description'], $result['itemTag']);
            if(!isset($sortedCategories[$result['categoryId']])){
                $sortedCategories[$result['categoryId']] = new MenuCategory($result['categoryId'],
                    $result['pagePosition'], $result['categoryName'], $result['categoryTag']);
                $sortedCategories[$result['categoryId']]->addItem($itemArray);
            } else {
                $sortedCategories[$result['categoryId']]->addItem($itemArray);
            }
        }

        return $sortedCategories;
    }

    /**
     * This function calls other functions that gets and returns data in the required structure
     * @return array|null
     */
    private function getMenuToEdit()
    {
        $rawResults = $this->menuRepo->getBilingualMenu();
        $categoryTags = $this->menuRepo->getCategoryTags();
        $matchedResultsAndCategories = $this->matchResultsWithCategoryTags($rawResults, $categoryTags);
        return $this->sortMenuResults($matchedResultsAndCategories);
    }

    /**
     * This function matches menu item data with categories, combing data for both languages
     * @param $results
     * @param BilingualMenuCategory[] $categoryTags
     * @return array
     */
    private function matchResultsWithCategoryTags($results, $categoryTags)
    {
        $items = array();
        $sortedResults = array();
        foreach ($results as $result) {
            $tag = $result['categoryTag'];

            if(!isset($items[$result['itemTag']])) {
                $items[$result['itemTag']] = new BilingualMenuItem($result['price'], $result['categoryPosition'], $result['itemTag']);
            }
            if($categoryTags[$tag] === null) {
                $categoryTags[$tag] = new BilingualMenuCategory($result['categoryTag'], $result['pagePosition'], $result['categoryType']);
            }

            if ($result['categoryLanguage'] === 'en') {
                $categoryTags[$tag]->setEnglish($result['categoryId'], $result['categoryName']);

                $items[$result['itemTag']]->setEnglish($result['id'], $result['title'], $result['description']);
            } else {
                $categoryTags[$tag]->setVietnamese($result['categoryId'], $result['categoryName']);

                $items[$result['itemTag']]->setVietnamese($result['id'], $result['title'], $result['description']);
            }
            $categoryTags[$tag]->addToItems($result['itemTag'], $items[$result['itemTag']]);
        }

        foreach ($categoryTags as $categoryTag) {
            $sortedCategory = array();
            foreach ($categoryTag->items as $item) {
                $sortedCategory[] = $item;
            }
            $categoryTag->setItems($sortedCategory);
            $sortedResults[] = $categoryTag;
        }

        return $sortedResults;
    }

    /**
     * This function sorts items by category position and categories by page position
     * @param $sortedResults
     * @return mixed
     */
    private function sortMenuResults($sortedResults)
    {
        foreach ($sortedResults as $key => $sortedResult) {
            usort($sortedResult->items, array('SortingService', 'comparisonPosition'));
            $sortedResults[$key] = $sortedResult;
        }
        usort($sortedResults, array('SortingService', 'comparisonPosition'));
        return $sortedResults;
    }
}