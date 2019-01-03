<?php
require_once '../ConnectDb.php';

// Services
require_once '../Services/SortingService.php';
require_once '../Services/Menu/BilingualMenuService.php';

// Repos
require_once '../Repository/Menu/MenuRepository.php';


class ReadMenu
{
    //Repos
    private $menuRepo;

    /**
     * @var string
     */
    private $language;

    function __construct()
    {
        // @todo: Remove this once params are sorted
        $this->menuRepo = new MenuRepository();
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
     * @todo: Refactor this as it is fugly
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
                $menuService = new BilingualMenuService();
                $results = $menuService->getMenu();
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
    private function sortRawData($results)
    {
        $sortedCategories = array();

        foreach ($results as $result) {
            $itemArray = new MenuItem($result['title'], $result['price'], $result['categoryPosition'],
                $result['id'], $result['description'], $result['itemTag']);
            if (!isset($sortedCategories[$result['categoryId']])) {
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