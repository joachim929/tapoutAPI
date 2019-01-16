<?php

// Objects
require_once __DIR__ . '/../../Objects/Shared/Message.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuDeleteRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuReadRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class MenuDeleteService
{

    // Services
    /**
     * @var SortingService
     */
    private $sortingService;

    // Repos
    /**
     * @var MenuDeleteRepository
     */
    private $deleteRepo;

    /**
     * @var MenuReadRepository
     */
    private $readRepo;

    // Variables
    /**
     * @var Message
     */
    private $message;

    public function __construct()
    {
        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->deleteRepo = new MenuDeleteRepository();
        $this->readRepo = new MenuReadRepository();

        //Variables
        $this->message = new Message();
    }

    public function initializeCategoryDelete($categoryId)
    {
        $data = $this->readRepo->getAllItemsByCategory($categoryId);
        if ($data !== false) {
            $this->deleteCategory($data);
        } else {
            $this->message->addWarning('Couldn\'t find any results with given category Id');
        }

        return $this->message;
    }

    public function initializeItemDelete(int $itemId)
    {
        $data = $this->readRepo->getItemById($itemId);

        if ($data !== false) {
            if ($this->deleteItem($data)) {
            }
        } else {
            $this->message->addWarning('Couldn\'t find any results with given item Id');
        }

        return $this->message;
    }

    /**
     * @param BilingualMenuCategory $category
     */
    private function deleteCategory(BilingualMenuCategory $category)
    {
        $check = true;

        if ($category->items !== null) {
            foreach ($category->items as $menuItem) {
                if (!$this->deleteItem($menuItem)) {
                    $check = false;
                }
            }
        } else {
            $check = false;
            $this->message->addWarning('Category doesn\'t have any items to delete');
        }
        if ($check === true) {
            if (!$this->deleteRepo->deleteCategory($category->id)) {
                $this->message->addError('Failed to delete category: ' . $category->id);
            }
        }
    }

    /**
     * @param BilingualMenuItem $item
     * @return bool
     */
    private function deleteItem(BilingualMenuItem $item)
    {
        $check = true;

        if ($this->deleteDescription($item->enId) && $this->deleteDescription($item->vnId)) {
            if (!$this->deleteRepo->deleteItem($item->itemId)) {
                $check = false;
                $this->message->addError('Failed to delete menu item: ' . $item->itemId);
            }
        } else {
            $check = false;
        }

        return $check;
    }

    /**
     * @param int $id
     * @return bool
     */
    private function deleteDescription(int $id)
    {
        $check = true;

        if(!$this->deleteRepo->deleteDescription($id)) {
            $check = false;
            $this->message->addError('Failed to delete menu item description: ' . $id);
        }

        return $check;
    }

}