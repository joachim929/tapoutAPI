<?php

// Objects
require_once '../Objects/Menu/BilingualMenuItem.php';
require_once '../Objects/Menu/BilingualMenuCategory.php';
require_once '../Objects/Shared/Message.php';
require_once '../Objects/Shared/Response.php';

// Services
require_once '../Services/Menu/CreateMenuItemService.php';
require_once '../Services/Menu/CreateMenuCategoryService.php';

class CreateMenu
{

    // @todo: After inserting re-order all of them again

    // Services
    /**
     * @var CreateMenuItemService
     */
    private $createItemService;

    /**
     * @var CreateMenuCategoryService
     */
    private $createCatService;

    // Variables
    /**
     * @var Message
     */
    private $message;

    /**
     * @var BilingualMenuItem|BilingualMenuCategory|null
     */
    private $data;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var string
     */
    private $task;

    public function __construct()
    {
        $this->createItemService = new CreateMenuItemService();
        $this->createCatService = new CreateMenuCategoryService();
        $this->message = new Message();
        $this->response = new Response();
    }

    public function returnStatement()
    {
        echo json_encode($this->checkParams());
    }

    /**
     * This function checks that the type of english/vietnamese descriptions match, if its a string it needs to
     * be >= 4 in length, creates error messages describing what went wrong if anything did go wrong
     * @param $enDescription
     * @param $vnDescription
     * @return bool
     */
    private function checkDescriptions($enDescription, $vnDescription)
    {
        $check = true;
        if (isset($enDescription, $vnDescription)) {
            if (!(is_string($enDescription) && is_string($vnDescription))) {
                $check = false;
                $this->message->addError('English and Vietnamese descriptions need to be strings');
            } else {
                if (strlen($enDescription) < 4) {
                    $check = false;
                    $this->message->addError('English description is too short');
                }
                if (strlen($vnDescription) < 4) {
                    $check = false;
                    $this->message->addError('Vietnamese description is too short');
                }
            }
        } elseif (!isset($enDescription) && isset($vnDescription)) {
            $check = false;
            $this->message->addError('Only got a value for Vietnamese description, not English description');
        } elseif (!isset($vnDescription) && isset($enDescription)) {
            $check = false;
            $this->message->addError('Only got a value for English description, not Vietnamese description');
        }

        return $check;
    }

    /**
     * This function checks that the post param module is valid
     * @return bool
     */
    private function checkModule(): bool
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

    private function checkNewCategory(): bool
    {
        $check = true;
        if (isset($_POST['newMenuCategory'])) {
            $temp = json_decode($_POST['newMenuCategory']);

            if (!$this->checkString('enCategoryName', $temp->enName)) {
                $check = false;
            }
            if (!$this->checkString('vnCategoryName', $temp->vnName)) {
                $check = false;
            }
            if (!$this->checkString('type', $temp->type)) {
                $check = false;
            }
            if (!$this->checkNumber('pagePosition', $temp->position)) {
                $check = false;
            }
            if ($check === true) {
                $this->data = new BilingualMenuCategory($temp->enName, $temp->vnName, $temp->type, $temp->position);
            }
        } else {
            $check = false;
            $this->message->addError('No item found in the expected place');
            $this->data = null;
        }

        return $check;
    }

    /**
     * This function checks all expected post parameters and returns a value on its findings
     * @return bool
     */
    private function checkNewItem(): bool
    {
        $check = true;
        if (isset($_POST['newMenuItem'])) {
            $temp = json_decode($_POST['newMenuItem']);

            if (!$this->checkNumber('category', $temp->category)) {
                $check = false;
            }
            if (!$this->checkString('caption', $temp->caption)) {
                $check = false;
            }
            if (!$this->checkString('English Title', $temp->enTitle)) {
                $check = false;
            }
            if (!$this->checkString('Vietnamese Title', $temp->vnTitle)) {
                $check = false;
            }
            if (!$this->checkNumber('category position', $temp->position)) {
                $check = false;
            }
            if (!$this->checkString('price', $temp->price)) {
                $check = false;
            }
            if (!$this->checkDescriptions($temp->enDescription, $temp->vnDescription)) {
                $check = false;
            }
            if ($check === true) {
                $this->data = new BilingualMenuItem($temp->price, $temp->position, $temp->caption,
                    $temp->enTitle, $temp->vnTitle, $temp->enDescription, $temp->vnDescription);
                $this->data->setCategoryId($temp->category);
            }
        } else {
            $check = false;
            $this->message->addError('No item found in the expected place');
            $this->data = null;
        }

        return $check;
    }

    /**
     * This function makes sure that a value is set and an int, if it isn't it creates an error message
     * @param string $type
     * @param        $value
     * @return bool
     */
    private function checkNumber(string $type, $value): bool
    {
        $check = true;
        if (!isset($value)) {
            $check = false;
            $this->message->addError("No value for $type given");
        } elseif (!is_int($value)) {
            $check = false;
            $this->message->addError("No valid value given for $value");
        }

        return $check;
    }

    /**
     * This function checks that page param is set and the correct value
     * @return bool
     */
    private function checkPage(): bool
    {
        $check = true;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
            if ($page !== 'Menu') {
                $check = false;
                $this->message->addError('Invalid page given');
            }
        } else {
            $check = false;
            $this->message->addError('Page not set');
        }

        return $check;
    }

    /**
     * This function makes sure all post params are good and if that is the case,
     * calls the create menu service
     */
    private function checkParams()
    {
        if ($this->checktask() && $this->checkPage() && $this->checkModule()) {

            $this->routeAction();
        }

        if ($this->response->hasMessages()) {
            $this->response->message->mergeMessages($this->message);
        } else {
            $this->response->setMessage($this->message);
        }


        return $this->response;
    }

    /**
     * This function makes sure that a value is set and a string, if it isn't it creates an error message
     * @param string $type
     * @param        $value
     * @return bool
     */
    private function checkString(string $type, $value): bool
    {
        $check = true;
        if (!isset($value)) {
            $check = false;
            $this->message->addError("No value for $type given");
        } elseif (!is_string($value)) {
            $check = false;
            $this->message->addError("No valid value given for $value");
        }

        return $check;
    }

    /**
     * This function checks that the page task is of expected value
     * @return bool
     */
    private function checkTask(): bool
    {

        $check = true;
        if (isset($_POST['task'])) {
            $task = $_POST['task'];
            if ($task === 'createMenuItem' && $this->checkNewItem()) {
                $this->task = $task;
            } elseif ($task === 'createMenuCategory' && $this->checkNewCategory()) {
                $this->task = $task;
            } else {
                $check = false;
                $this->message->addError('Invalid task given');
            }
        } else {
            $check = false;
            $this->message->addError('Task is not set');
        }

        return $check;
    }

    /**
     * This function calls the service corresponding to the task
     */
    private function routeAction()
    {
        if ($this->task === 'createMenuItem') {
            $this->response->mergeResponse($this->createItemService->addNewItem($this->data));
        } elseif ($this->task === 'createMenuCategory') {
            $this->response->mergeResponse($this->createCatService->addNewCategory($this->data));
        } else {
            $this->message->addError('Something went wrong with the task: ' . $this->task);
        }
    }

}