<?php

// Objects
require_once '../Objects/Menu/MenuItem.php';
require_once '../Objects/Menu/MenuCategory.php';
require_once '../Objects/Menu/BilingualMenuItem.php';
require_once '../Objects/Menu/BilingualMenuCategory.php';
require_once '../Objects/Shared/Response.php';

// Services
require_once '../Services/Menu/MenuGuestService.php';
require_once '../Services/Menu/MenuAdminReadService.php';

class ReadMenu
{

    // Services

    /**
     * @var MenuGuestService
     */
    private $guestMenuService;
    /**
     * @var MenuAdminReadService
     */
    private $adminMenuService;

    // Variables
    /**
     * @var string;
     */
    private $page;
    /**
     * @var string
     */
    private $task;
    /**
     * @var string
     */
    private $language;
    /**
     * @var string
     */
    private $module;

    public function __construct ()
    {

        $this->guestMenuService = new MenuGuestService();
        $this->adminMenuService = new MenuAdminReadService();
    }

    /**
     * This function is the entry point of the class
     */
    public function returnStatement ()
    {

        $results = $this->checkParams();

        if ($results === []) {
            $results = null;
        }

        echo json_encode($results);
    }

    /**
     * This function checks the $_GET params and calls functions depending on the params
     * @return array|null
     */
    private function checkParams ()
    {

        if (isset($_GET['page']) && $_GET['page'] === 'Menu') {
            $this->page = $_GET['page'];
        }
        if (isset($_GET['module']) && ($_GET['module'] === 'Admin' || $_GET['module'] === 'Guest')) {
            $this->module = $_GET['module'];
        }
        if (isset($_GET['task']) && $_GET['task'] === 'read' || $_GET['task'] === 'edit') {
            $this->task = $_GET['task'];
        }
        if (isset($_GET['lang'])) {
            if ($_GET['lang'] === 'vn' || $_GET['lang'] === 'en') {
                $this->language = $_GET['lang'];
            }
        }

        return $this->controlParams();
    }

    private function controlParams ()
    {

        $results = null;

        if ($this->language === null && $this->module === 'Admin') {
            if ($this->task === 'edit') {
                $results = $this->adminMenuService->getMenu();
            }
        } else {
            if ($this->task === 'read' && $this->module === 'Guest') {
                $results = $this->guestMenuService->getMenu($this->language);
            }
        }

        return $results;
    }

}