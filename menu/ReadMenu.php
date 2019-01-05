<?php
// Services
require_once '../Services/Menu/MenuService.php';
require_once '../Services/Menu/BilingualMenuService.php';

class ReadMenu
{
    function __construct()
    {}

    /**
     * This function is the entry point of the class
     */
    public function returnStatement()
    {
        $results = $this->checkParams();

        if($results === []) {
            $results = null;
        }

        return $results;
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
                $language = $_GET['lang'];
                $menuService = new MenuService();
                $results = $menuService->getMenu($language);
            }
            //Case for editing web page
            if (!isset($_GET['lang']) && $_GET['task'] === 'edit') {
                $menuService = new BilingualMenuService();
                $results = $menuService->getMenu();
            }
        }
        return $results;
    }
}