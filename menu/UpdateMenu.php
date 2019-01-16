<?php

//Objects
require_once '../Objects/Shared/Message.php';
require_once '../Objects/Shared/Response.php';
require_once '../Objects/Menu/BilingualMenuCategory.php';
require_once '../Objects/Menu/BilingualMenuItem.php';

// Services
require_once '../Services/Menu/MenuUpdateCategoryService.php';
require_once '../Services/Menu/MenuUpdateItemService.php';
require_once '../Services/Shared/SortingService.php';

class UpdateMenu
{

    // Services
    /**
     * @var MenuUpdateCategoryService
     */
    private $categoryService;

    /**
     * @var MenuUpdateItemService
     */
    private $itemService;

    /**
     * @var SortingService
     */
    private $sortingService;

    // Variables

    /**
     * @var Message
     */
    private $message;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var BilingualMenuCategory|BilingualMenuItem
     */
    private $updateItem;

    /**
     * @var string
     */
    private $task;

    public function __construct ()
    {

        $this->categoryService = new MenuUpdateCategoryService();
        $this->itemService = new MenuUpdateItemService();
        $this->sortingService = new SortingService();

        $this->message = new Message();
        $this->response = new Response();
    }

    public function returnStatement ()
    {

        echo json_encode($this->checkParams());
    }

    private function checkParams ()
    {

        if ($this->checkPage() && $this->checkModule() && $this->checkTask()) {
            if ($this->task === 'updateCategory') {
                $this->categoryService->updateCategory($this->updateItem);

            } elseif ($this->task === 'updateItem') {
                $this->itemService->updateItem($this->updateItem);
            }
        }

        if ($this->response->hasMessages()) {
            $this->response->message->mergeMessages($this->message);
        } else {
            $this->response->setMessage($this->message);
        }

        return $this->response;
    }

    /**
     * This function checks all post params are valid for updating a menu item
     * @return bool
     */
    private function checkItem ()
    {

        $check = true;
        if (isset($_POST['item'])) {
            $item = json_decode($_POST['item']);

            if (true !== ($catIdCheck = $this->sortingService->checkNumber('Category Id', $item->categoryId))) {
                $this->message->addError($catIdCheck);
                $check = false;
            }

            if (true !== ($itemIdCheck = $this->sortingService->checkNumber('Item Id', $item->itemId))) {
                $this->message->addError($itemIdCheck);
                $check = false;
            }

            if (true !== ($enIdCheck = $this->sortingService->checkNumber('English description Id', $item->enId))) {
                $this->message->addError($enIdCheck);
                $check = false;
            }

            if (true !== ($vnIdCheck = $this->sortingService->checkNumber('Vietnamese description Id', $item->vnId))) {
                $this->message->addError($vnIdCheck);
                $check = false;
            }

            if (true !== ($enTitleCheck = $this->sortingService->checkString('English title', $item->enTitle))) {
                $this->message->addError($enTitleCheck);
                $check = false;
            }

            if (true !== ($vnTitleCheck = $this->sortingService->checkString('Vietnamese title', $item->vnTitle))) {
                $this->message->addError($vnTitleCheck);
                $check = false;
            }

            if (true !== ($positionCheck = $this->sortingService->checkNumber('Category position', $item->position))) {
                $this->message->addError($positionCheck);
                $check = false;
            }

            if (true !== ($priceCheck = $this->sortingService->checkString('Price', $item->price))) {
                $this->message->addError($priceCheck);
                $check = false;
            }

            if (true !== $descriptionCheck = $this->sortingService->checkDescriptions($item->enDescription, $item->vnDescription)) {
                $this->message->addError($descriptionCheck);
                $check = false;
            }
        } else {
            $this->message->addError('No item to update was set');
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks all post params are valid for updating a menu category
     * @return bool
     */
    private function checkCategory ()
    {

        $check = true;
        if (isset($_POST['item'])) {
            $item = json_decode($_POST['item']);

            if (true !== ($idCheck = $this->sortingService->checkNumber('Category Id', $item->id))) {
                $this->message->addError($idCheck);
                $check = false;
            }

            if (true !== ($enNameCheck = $this->sortingService->checkString('English Category Name', $item->enName))) {
                $this->message->addError($enNameCheck);
                $check = false;
            }

            if (true !== ($vnNameCheck = $this->sortingService->checkString('Vietnamese Category Name', $item->vnName))) {
                $this->message->addError($vnNameCheck);
                $check = false;
            }

            if (true !== ($categoryTypeCheck = $this->sortingService->checkMenuCategoryType($item->type))) {
                $this->message->addError($categoryTypeCheck);
                $check = false;
            }

            if (true !== ($positionCheck = $this->sortingService->checkNumber('Page position', $item->position))) {
                $this->message->addError($positionCheck);
                $check = false;
            }

        } else {
            $this->message->addError('No item to update was set');
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
    private function checkPage ()
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
    private function checkTask ()
    {

        $check = true;
        if (isset($_POST['task']) && is_string($_POST['task'])) {
            $this->task = $_POST['task'];

            if ($this->task === 'updateItem' && $this->checkItem()) {
                $item = json_decode($_POST['item']);
                $this->updateItem = new BilingualMenuItem($item->price, $item->position, $item->enTitle,
                    $item->vnTitle, $item->enDescription, $item->vnDescription, $item->enId, $item->vnId, $item->itemId);
                $this->updateItem->setCategoryId($item->categoryId);

            } elseif ($this->task === 'updateCategory' && $this->checkCategory()) {
                $item = json_decode($_POST['item']);
                $this->updateItem = new BilingualMenuCategory($item->enName, $item->vnName, $item->type, $item->position,
                    $item->id);

            } else {
                $check = false;
                $this->message->addWarning('Invalid task given');

            }

        } else {
            $this->message->addError('No task set');
            $check = false;
        }

        return $check;
    }

}