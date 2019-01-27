<?php

// Objects

// Services
require_once '../Services/Menu/MenuDeleteService.php';

class DeleteMenu
{

    // Services

    /**
     * @var MenuDeleteService
     */
    private $deleteMenuService;

    public function __construct ()
    {

        $this->deleteMenuService = new MenuDeleteService();
    }

    public function returnStatement ()
    {

        echo json_encode($this->checkParams());
    }

    private function checkParams ()
    {
        $check = true;
        if ($this->checkpage() && $this->checkModule() && $this->checkTask()) {
            $check = $this->checkItem();
        }

        return $check;
    }

    /**
     * This function checks the item and routes to the correct service method depending on the variables
     */
    private function checkItem (): bool
    {
        $check = true;
        if (isset($_POST['item'])) {
            $item = json_decode($_POST['item']);
            if (isset($item->id)) {
                if (isset($item->type) && $item->type === 'category') {
                    $this->deleteMenuService->initializeCategoryDelete($item->id);
                } elseif (isset($item->type) && $item->type === 'item') {
                    $this->deleteMenuService->initializeItemDelete($item->id);
                } else {
                    $check = false;
                }
            } else {
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks to see if module param has been set and is valid
     * @return bool
     */
    private function checkModule ()
    {

        $check = true;
        if (isset($_POST['module'])) {
            $module = $_POST['module'];
            if ($module !== 'Admin') {
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks to see if the page param has been set and is valid
     * @return bool
     */
    private function checkPage ()
    {

        $check = true;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];

            if (!is_string($page)) {
                $check = false;
            } elseif ($page !== 'Menu') {
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks to see if the task param has been set and is valid
     * @return bool
     */
    private function checkTask ()
    {

        $check = true;
        if (isset($_POST['task'])) {
            $task = $_POST['task'];
            if (!is_string($task) || ($task !== 'deleteCategory' && $task !== 'deleteItem')) {
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }

}