<?php

// Objects
require_once '../Objects/Shared/Message.php';

// Services
require_once '../Services/Menu/DeleteMenuService.php';

class DeleteMenu
{

    // Services
    /**
     * @var DeleteMenuService
     */
    private $deleteMenuService;

    /**
     * @var Message
     */
    private $message;

    public function __construct()
    {
        $this->deleteMenuService = new DeleteMenuService();
        $this->message = new Message();
        $this->response = new Response();
    }

    public function returnStatement()
    {
        echo json_encode($this->checkParams());
    }

    private function checkParams()
    {
        if ($this->checkpage() && $this->checkModule() && $this->checkTask()) {
            $this->checkItem();
        }

        return $this->message;
    }

    /**
     * This function checks the item and routes to the correct service method depending on the variables
     */
    private function checkItem()
    {
        if (isset($_POST['item'])) {
            $item = json_decode($_POST['item']);
            if (isset($item->id)) {
                if (isset($item->type) && $item->type === 'category') {
                    $this->deleteMenuService->initializeCategoryDelete($item->id);
                } elseif (isset($item->type) && $item->type === 'item') {
                    $this->deleteMenuService->initializeItemDelete($item->id);
                } else {
                    $this->message->addWarning('No item/category was set to be deleted');
                }
            } else {
                $this->message->addWarning('No item id was set');
            }
        } else {
            $this->message->addError('No item was set');
        }
    }

    /**
     * This function checks to see if module param has been set and is valid
     * @return bool
     */
    private function checkModule()
    {
        $check = true;
        if (isset($_POST['module'])) {
            $module = $_POST['module'];
            if ($module !== 'Admin') {
                $check = false;
                $this->message->addError('Invalid module given');
            }
        } else {
            $check = false;
            $this->message->addError('Module not set');
        }

        return $check;
    }

    /**
     * This function checks to see if the page param has been set and is valid
     * @return bool
     */
    private function checkPage()
    {
        $check = true;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];

            if (!is_string($page)) {
                $this->message->addError('Page isn\'t a string');
                $check = false;
            } elseif ($page !== 'Menu') {
                $this->message->addError('Invalid page');
                $check = false;
            }

        } else {
            $this->message->addError('Page wasn\'t set');
            $check = false;
        }
        return $check;
    }

    /**
     * This function checks to see if the task param has been set and is valid
     * @return bool
     */
    private function checkTask()
    {
        $check = true;
        if (isset($_POST['task'])) {
            $task = $_POST['task'];
            if(!is_string($task) || ($task !== 'deleteCategory' && $task !== 'deleteItem')) {
                $this->message->addError('Incorrect task set');
                $check = false;
            }
        } else {
            $this->message->addError('No task set');
            $check = false;
        }

        return $check;
    }
}