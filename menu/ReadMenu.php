<?php
// Services
require_once '../Services/Menu/MenuService.php';
require_once '../Services/Menu/BilingualMenuService.php';

class ReadMenu
{
    private $page = null;
    private $task = null;
    private $language = null;

    public function __construct()
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
        if (isset($_GET['page']) && $_GET['page'] === 'Menu') {
            $this->page = $_GET['page'];
        }
        if (isset($_GET['task']) && $_GET['task'] === 'read' || $_GET['task'] === 'edit' || $_GET['task'] === 'getCategories') {
            $this->task = $_GET['task'];
        }
        if (isset($_GET['lang'])) {
            if($_GET['lang'] === 'vn' || $_GET['lang'] === 'en') {
                $this->language = $_GET['lang'];
            }
        }
        return $this->controlParams();
    }

    private function controlParams()
    {
        $results = null;

        if ($this->language === null) {
            $menuService = new BilingualMenuService();
            if ($this->task === 'edit') {
                $results = $menuService->getMenu();
            } elseif ($this->task === 'getCategories') {
                $results = $menuService->getCategories();
            }
        } else {
            if ($this->task === 'read') {
                $menuService = new MenuService();
                $results = $menuService->getMenu($this->language);
            }
        }

        return $results;
    }
}