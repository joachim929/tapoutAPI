<?php

// Objects
require_once '../Objects/Menu/BilingualMenuItem.php';
require_once '../Objects/Menu/BilingualMenuCategory.php';
require_once '../Objects/Shared/Response.php';

// Services
require_once '../Services/Menu/MenuCreateItemService.php';
require_once '../Services/Menu/MenuCreateCategoryService.php';
require_once '../Services/Shared/SortingService.php';

class CreateMenu
{

    // Services

    /**
     * @var MenuCreateItemService
     */
    private $createItemService;

    /**
     * @var MenuCreateCategoryService
     */
    private $createCatService;

    /**
     * @var SortingService
     */
    private $sortingService;

    // Variables

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

        $this->createItemService = new MenuCreateItemService();
        $this->createCatService = new MenuCreateCategoryService();
        $this->sortingService = new SortingService();
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
            } else {
                if (strlen($enDescription) < 4) {
                    $check = false;
                }
                if (strlen($vnDescription) < 4) {
                    $check = false;
                }
            }
        } elseif (!isset($enDescription) && isset($vnDescription)) {
            $check = false;
        } elseif (!isset($vnDescription) && isset($enDescription)) {
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks that the post param module is valid
     * @return bool
     */
    private function checkModule() : bool
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

    private function checkNewCategory() : bool
    {

        $check = true;
        if (isset($_POST['newMenuCategory'])) {
            $temp = json_decode($_POST['newMenuCategory']);

            if (!$this->sortingService->checkString($temp->enName)) {
                $check = false;
            }
            if (!$this->sortingService->checkString($temp->vnName)) {
                $check = false;
            }
            if (!$this->sortingService->checkString($temp->type)) {
                $check = false;
            }
            if (!$this->sortingService->checkNumber($temp->position)) {
                $check = false;
            }
            if ($check === true) {
                $this->data = new BilingualMenuCategory(
                    $temp->enName, $temp->vnName, $temp->type, $temp->position);
            }
        } else {
            $check = false;
            $this->data = null;
        }

        return $check;
    }

    /**
     * This function checks all expected post parameters and returns a value on its findings
     * @return bool
     */
    private function checkNewItem() : bool
    {

        $check = true;
        if (isset($_POST['newMenuItem'])) {
            $temp = json_decode($_POST['newMenuItem']);

            if (!$this->sortingService->checkNumber($temp->category)) {
                $check = false;
            }
            if (!$this->sortingService->checkString($temp->enTitle)) {
                $check = false;
            }
            if (!$this->sortingService->checkString($temp->vnTitle)) {
                $check = false;
            }
            if (!$this->sortingService->checkNumber($temp->position)) {
                $check = false;
            }
            if (!$this->sortingService->checkString($temp->price)) {
                $check = false;
            }
            if (!$this->checkDescriptions($temp->enDescription, $temp->vnDescription)) {
                $check = false;
            }
            if ($check === true) {
                $this->data = new BilingualMenuItem(
                    $temp->price, $temp->position, $temp->enTitle,
                    $temp->vnTitle, $temp->enDescription, $temp->vnDescription,
                    null, null, null);

                $this->data->setCategoryId($temp->category);
            }
        } else {
            $check = false;
            $this->data = null;
        }

        return $check;
    }

    /**
     * This function checks that page param is set and the correct value
     * @return bool
     */
    private function checkPage() : bool
    {
        $check = true;
        if ($this->sortingService->checkPage($_POST['page'])) {
            $page = $_POST['page'];

            if ($page !== 'Menu') {
                $check = false;

            }
        } else {
            $check = false;
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

        return $this->response;
    }

    /**
     * This function checks that the page task is of expected value
     * @return bool
     */
    private function checkTask() : bool
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

            }
        } else {
            $check = false;
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
        }
    }

}