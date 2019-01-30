<?php

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuDeleteRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuReadRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuCategoryRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuAdminRepository.php';

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
    /**
     * @var MenuCategoryRepository
     */
    private $categoryRepo;
    /**
     * @var MenuAdminRepository
     */
    private $adminRepo;

    // Variables
    /**
     * @var BilingualMenuCategory
     */
    private $category;

    public function __construct()
    {

        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->deleteRepo = new MenuDeleteRepository();
        $this->readRepo = new MenuReadRepository();
        $this->categoryRepo = new MenuCategoryRepository();
        $this->adminRepo = new MenuAdminRepository();

    }

    /**
     * @todo: Check if category exists.
     *      Create menu category with result
     *      Get all (if any) items
     *      Then delete item descriptions (this works already)
     *      Then delete items (this doesn't work)
     *      Then delete category
     */

    /**
     * @param $categoryId
     * @return bool
     */
    public function initializeCategoryDelete($categoryId)
    {
        $check = true;
        if ($this->checkCategoryExists($categoryId)) {
            $data = $this->readRepo->getAllItemsByCategory($categoryId);
            if ($data !== false) {
                if (!$this->deleteCategory($data)) {
                    $check = false;
                }
            } else {
                if (!$this->deleteRepo->deleteCategory($categoryId)) {
                    $check = false;
                }
            }
        } else {
            $check = false;
        }
        $this->reorderCategories();

        return $check;
    }

    private function reorderCategories()
    {
        $categories = $this->categoryRepo->getCategories();

        if ($categories !== null && count($categories) > 0) {
            $index = 1;
            foreach ($categories as $category) {
                if ($category->position !== $index) {
                    $category->setPosition($index);
                    $this->adminRepo->patchCategoryPosition($category);
                }
                $index++;
            }
        }
    }

    public function checkCategoryExists(int $categoryId)
    {
        $check = false;
        $categories = $this->categoryRepo->getCategories();

        foreach ($categories as $category) {
            if ($category->id === $categoryId) {
                $this->category = $category;
                $check = true;
                break;
            }
        }

        return $check;
    }

    public function initializeItemDelete(int $itemId)
    {
        $check = true;
        $data = $this->readRepo->getItemById($itemId);

        if ($data !== false) {
            if (!$this->deleteItem($data)) {
                $check = false;
            }
        } else {
            $check = false;
        }
        $this->reorderCategoryItems($data);

        return $check;
    }

    private function reorderCategoryItems($data)
    {
        $items = $this->readRepo->getItemsByCategory($data->categoryId);

        if ($items !== null && count($items) > 0) {
            $index = 1;
            foreach ($items as $item) {
                if ($item->position !== $index) {
                    $item->setPosition($index);
                    $this->adminRepo->patchMenuItemPosition($item);
                }
                $index++;
            }
        }

    }

    private function deleteCategory(BilingualMenuCategory $category)
    {

        $check = true;

        if ($category->items !== null) {
            foreach ($category->items as $menuItem) {
                if (!$this->deleteItem($menuItem)) {
                    $check = false;
                }
            }
        }
        if (!$this->deleteRepo->deleteCategory($category->id)) {
            $check = false;
        }

        return $check;

    }

    /**
     * @param BilingualMenuItem $item
     * @return bool
     */
    private function deleteItem(BilingualMenuItem $item)
    {

        $check = true;

        if ($item->enId !== null) {
            if (!$this->deleteDescription($item->enId)) {
                $check = false;
            }
        }
        if ($item->vnId !== null) {
            if (!$this->deleteDescription($item->vnId)) {
                $check = false;
            }
        }
        if (!$this->deleteRepo->deleteItem($item->itemId)) {
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