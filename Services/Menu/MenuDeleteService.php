<?php

// Objects

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
        }
        if ($check === true) {
            if (!$this->deleteRepo->deleteCategory($category->id)) {
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

        if (!$this->deleteRepo->deleteDescription($id)) {
            $check = false;
        }

        return $check;
    }

}