<?php
// Services
require_once __DIR__ . '/../SortingService.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuItemRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuCategoryRepository.php';

class CreateMenuItem
{
    // Services
    private $sortingService;

    // Repos
    private $menuItemRepo;
    private $menuCatRepo;

    public function __construct()
    {
        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->menuItemRepo = new MenuItemRepository();
        $this->menuCatRepo = new MenuCategoryRepository();
    }

    /**
     * This function checks that the given category id exists and that the caption is unique
     * @param $data
     * @return array
     */
    public function addNewItem($data)
    {
        $category = $this->menuCatRepo->getCategoryById($data->category);
        $uniqueCaptionCheck = $this->menuItemRepo->getItemByCaption($data->caption);
        if ($category === null) {
            $result = [
                'error' => 'Given category id doesn\'t exist'
            ];
        } elseif (isset($uniqueCaptionCheck->id) && $uniqueCaptionCheck->id !== null) {
            $result = [
                'error' => 'The given caption wasn\'t unique'
            ];
        } else {
            $result = $this->insertItem($data);
        }
        return $result;
    }

    /**
     * This function checks to see if creating a new menu item worked
     * @param $data
     * @return array
     */
    private function insertItem($data)
    {
        $result = [];
        if(!$this->menuItemRepo->insertNewItem($data->category, $data->caption, $data->price,
            $data->categoryPosition)) {
            $result[] = [
                'error' => 'Failed to insert new item'
            ];
        } else {
            $result = $this->insertItemDetails($data);
        }
        if ($result === []) {
            //    @todo: Update category positions
            $result = $this->checkCategoryPosition($data->categoryPosition);
        }

        return $result;
    }

    /**
     * Loops through all menu items in a category and makes sure the category position is correct
     * @param int $categoryId
     * @return array
     */
    private function checkCategoryPosition(int $categoryId)
    {
        $check = [];
        $menuItems = $this->menuItemRepo->cgetItemsByCategory($categoryId);
        if ($menuItems === false) {
            $check[] = ['error' => 'Something went wrong in cgetItems'];
        } else {
            $index = 1;
            foreach ($menuItems as $menuItem) {
                $menuItem->categoryPosition = $index;
                if(!$this->menuItemRepo->patchItem($menuItem->id, $menuItem->categoryId, $menuItem->caption,
                    $menuItem->price, $menuItem->categoryPosition)) {
                    $check[] = [
                        'error' => 'Failed updating menu item, caption: '
                            . $menuItem->caption . ', Id: ' . $menuItem->id
                    ];
                }

                $index++;
            }
        }

        return $check;
    }

    /**
     * This function tries to get the newly created menu item, and add descriptions to it
     * @param $data
     * @return array
     */
    private function insertItemDetails($data)
    {
        $results = [];
        $newItem = $this->menuItemRepo->getItemByCaption($data->caption);
        if (isset($newItem->id)) {
            $data->itemId = $newItem->id;
            if($data->enDescription === null) {
                if(!$this->menuItemRepo->insertNewItemDetailsNoDesc($data->itemId, $data->enTitle, 'en')) {
                    $result[] = [
                        'error' => 'Failed to insert new English details, no description'
                    ];
                }
                if(!$this->menuItemRepo->insertNewItemDetailsNoDesc($data->itemId, $data->vnTitle, 'vn')) {
                    $result[] = [
                        'error' => 'Failed to insert new Vietnamese details, no description'
                    ];
                }
            } else {
                if(!$this->menuItemRepo->insertNewItemDetails($data->itemId, $data->enTitle, $data->enDescription, 'en')) {
                    $result[] = [
                        'error' => 'Failed to insert new English details'
                    ];
                }
                if(!$this->menuItemRepo->insertNewItemDetails($data->itemId, $data->vnTitle, $data->vnDescription, 'vn')) {
                    $result[] = [
                        'error' => 'Failed to insert new Vietnamese details'
                    ];
                }
            }
        }
        return $results;
    }
}