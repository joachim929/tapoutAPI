<?php

//Objects
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
     * @var Response
     */
    private $response;

    /**
     * @var BilingualMenuCategory|BilingualMenuItem|array
     */
    private $updateItem;

    /**
     * @var string
     */
    private $task;

    public function __construct()
    {

        $this->categoryService = new MenuUpdateCategoryService();
        $this->itemService = new MenuUpdateItemService();
        $this->sortingService = new SortingService();

        $this->response = new Response();
    }

    public function returnStatement()
    {

        echo json_encode($this->checkParams());
    }

    private function checkParams()
    {
        if ($this->checkPage() && $this->checkModule() && $this->checkTask()) {
            if ($this->task === 'updateCategory') {
                $this->response = $this->categoryService->updateCategory($this->updateItem);

            } elseif ($this->task === 'updateItem') {
                $this->response = $this->itemService->updateItem($this->updateItem);

            } elseif ($this->task === 'updateCategoryPosition') {
                $this->response = $this->categoryService->updateCategoryPosition($this->updateItem);

            } elseif ($this->task === 'updateItemPosition') {
                $this->response = $this->itemService->swapItemPositions($this->updateItem);
            }
        }

        return $this->response;
    }

    /**
     * This function checks all post params are valid for updating a menu item
     * @return bool
     */
    private function checkItem()
    {

        $check = true;
        if (isset($_POST['item'])) {
            $item = json_decode($_POST['item']);

            if (true !== ($catIdCheck = $this->sortingService->checkNumber($item->categoryId))) {
                $check = false;
            }

            if (true !== ($itemIdCheck = $this->sortingService->checkNumber($item->itemId))) {
                $check = false;
            }

            if (true !== ($enIdCheck = $this->sortingService->checkNumber($item->enId))) {
                $check = false;
            }

            if (true !== ($vnIdCheck = $this->sortingService->checkNumber($item->vnId))) {
                $check = false;
            }

            if (true !== ($enTitleCheck = $this->sortingService->checkString($item->enTitle))) {
                $check = false;
            }

            if (true !== ($vnTitleCheck = $this->sortingService->checkString($item->vnTitle))) {
                $check = false;
            }

            if (true !== ($positionCheck = $this->sortingService->checkNumber($item->position))) {
                $check = false;
            }

            if (true !== ($priceCheck = $this->sortingService->checkString($item->price))) {
                $check = false;
            }

            if (true !== $descriptionCheck = $this->sortingService->checkDescriptions($item->enDescription, $item->vnDescription)) {
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks all post params are valid for updating a menu category
     * @return bool
     */
    private function checkCategory()
    {

        $check = true;
        if (isset($_POST['item'])) {
            $item = json_decode($_POST['item']);

            if (true !== ($idCheck = $this->sortingService->checkNumber($item->id))) {
                $check = false;
            }

            if (true !== ($enNameCheck = $this->sortingService->checkString($item->enName))) {
                $check = false;
            }

            if (true !== ($vnNameCheck = $this->sortingService->checkString($item->vnName))) {
                $check = false;
            }

            if (true !== ($categoryTypeCheck = $this->sortingService->checkMenuCategoryType($item->type))) {
                $check = false;
            }

            if (true !== ($positionCheck = $this->sortingService->checkNumber($item->position))) {
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
    private function checkModule()
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
    private function checkPage()
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
    private function checkTask()
    {

        $check = true;
        if (isset($_POST['task']) && is_string($_POST['task'])) {
            $this->task = $_POST['task'];

            if ($this->task === 'updateItem' && $this->checkItem()) {
                $item = json_decode($_POST['item']);

                $this->updateItem = new BilingualMenuItem($item->price, $item->position, $item->enTitle,
                    $item->vnTitle, $item->enDescription, $item->vnDescription, $item->enId,
                    $item->vnId, $item->itemId);

                $this->updateItem->setCategoryId($item->categoryId);

            } elseif ($this->task === 'updateCategory' && $this->checkCategory()) {
                $item = json_decode($_POST['item']);

                $this->updateItem = new BilingualMenuCategory(
                    $item->enName, $item->vnName, $item->type, $item->position,
                    $item->id);

            } elseif ($this->task === 'updateItemPosition') {
                $items = json_decode($_POST['items']);
                if (count($items) === 2) {
                    $this->setUpdateItemForItemPositionUpdate($items);
                }

            } elseif ($this->task === 'updateCategoryPosition') {
                $items = json_decode($_POST['items']);
                if (count($items) === 2) {
                    $this->setUpdateItemForCategoryPositionUpdate($items);
                }
            } else {
                $check = false;

            }

        } else {
            $check = false;
        }

        return $check;
    }

    private function setUpdateItemForItemPositionUpdate(array $items)
    {
        $this->updateItem[] = new BilingualMenuItem(
            $items[0]->price, $items[0]->position, $items[0]->enTitle, $items[0]->vnTitle,
            $items[0]->enDescription, $items[0]->vnDescription, $items[0]->enId,
            $items[0]->vnId, $items[0]->itemId);
        $this->updateItem[0]->setCategoryId($items[0]->categoryId);
        $this->updateItem[] = new BilingualMenuItem(
            $items[1]->price, $items[1]->position, $items[1]->enTitle, $items[1]->vnTitle,
            $items[1]->enDescription, $items[1]->vnDescription, $items[1]->enId,
            $items[1]->vnId, $items[1]->itemId);
        $this->updateItem[1]->setCategoryId($items[1]->categoryId);
    }

    private function setUpdateItemForCategoryPositionUpdate(array $items)
    {
        $this->updateItem[] = new BilingualMenuCategory(
            $items[0]->enName, $items[0]->vnName, $items[0]->type, $items[0]->position, $items[0]->id,
            $items[0]->createdAt, $items[0]->editedAt);
        $this->updateItem[] = new BilingualMenuCategory(
            $items[1]->enName, $items[1]->vnName, $items[1]->type, $items[1]->position, $items[1]->id,
            $items[1]->createdAt, $items[1]->editedAt);
    }

}