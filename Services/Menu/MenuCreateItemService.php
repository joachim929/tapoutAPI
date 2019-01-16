<?php

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Menu/RawMenuItem.php';
require_once __DIR__ . '/../../Objects/Shared/Message.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuAdminRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';


class MenuCreateItemService
{

    // Services
    /**
     * @var SortingService
     */
    private $sortingService;

    // Repos
    /**
     * @var MenuAdminRepository
     */
    private $adminRepo;

    // Variables
    /**
     * @var Message
     */
    private $message;

    /**
     * @var Response
     */
    private $response;

    public function __construct()
    {
        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->adminRepo = new MenuAdminRepository();

        //Variables
        $this->message = new Message();
        $this->response = new Response();
    }

    /**
     * This function adds a new menu item into the database and on success calls functions that will insert
     * the menu item details. It returns Response which should contain data, and any warning/error messages
     * @param BilingualMenuItem $data
     * @return Response
     */
    public function addNewItem(BilingualMenuItem $data)
    {
        $itemId = $this->adminRepo->newItem($data);
        if ($itemId !== false) {
            $data->setItemId($itemId);

            $this->addNewItemDetails($data);

            if ($this->response->success === true) {
                $this->reorderMenuItems($data);
            }

        } else {
            $this->message->addError('Failed to insert menu item');
        }
        $this->response->setData($data);
        $this->response->setMessage($this->message);
        return $this->response;
    }

    /**
     * @todo: Fix so that if a newly assigned item has been added that it retains the category position,
     * @todo -      older items should all move up one position
     * This function assigns a new page position if it isn't the same as index
     * This is so that there are no duplicate category positions
     * @param BilingualMenuItem $data
     */
    private function reorderMenuItems(BilingualMenuItem $data)
    {
        $menuItems = $this->adminRepo->getAllMenuItemsByCategory($data->categoryId);

        if($menuItems !== false) {
            $index = 1;
            foreach ($menuItems as $key => $menuItem) {
                if ($menuItem->position !== $index) {
                    $menuItem->setPosition($index);
                    if(!$this->adminRepo->patchMenuItemPosition($menuItem)) {
                        $this->message->addWarning('Was an error updating menu item with caption: '
                            . $menuItem->getCaption());
                    }
                }
                $index++;
            }
        } else {
            $this->message->addWarning('Failed to get menu items by category, therefore couldn\'t reorder');
        }
    }

    /**
     * This function insert menu item details into the database and checks that it succeeded in doing so
     * @param BilingualMenuItem $data
     */
    private function addNewItemDetails(BilingualMenuItem $data)
    {
        $enItemId = $this->adminRepo->newItemDetails($data->itemId, $data->enTitle,
            $data->enDescription, 'en');
        if($enItemId === false) {
            $this->response->setSuccess(false);
            $this->message->addError('Failed to insert English menu item details');
        } else {
            $data->setEnId($enItemId);

            $vnItemId = $this->adminRepo->newItemDetails($data->itemId, $data->vnTitle,
                $data->vnDescription, 'vn');

            if($vnItemId === false) {
                $this->message->addError('Failed to insert Vietnamese menu item details');
                $this->response->setSuccess(false);
            } else {
                $data->setVnId($vnItemId);
                $this->response->setSuccess(true);
            }
        }
    }

}