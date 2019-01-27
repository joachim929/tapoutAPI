<?php

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuDeleteRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuReadRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuCategoryRepository.php';

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
                $this->deleteCategory($data);
            } else {
                if (!$this->deleteRepo->deleteCategory($categoryId)) {
                    $check = false;
                }
            }
        } else {
            $check = false;
        }

        return $check;
    }

    private function sortMenuResults($rawResults)
    {
        foreach ($rawResults as $result) {
            if (!isset($sortedResults)) {
                if ($result['catId'] !== null) {
                    $sortedResults = new BilingualMenuCategory($result['catEnName'],
                        $result['catVnName'], $result['catType'], $result['pagePosition'],
                        $result['catId'], $result['createdAt'], $result['editedAt']);
                }
            }

            //if (isset($result['itemId']))
        }

        return $sortedResults;
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

        return $check;
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
            if ($this->deleteDescription($item->vnId)) {
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