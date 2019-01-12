<?php
// Services
require_once __DIR__ . '/../Shared/SortingService.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Menu/RawMenuItem.php';
require_once __DIR__ . '/../../Objects/Shared/Message.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuAdminRepository.php';

class CreateMenuItemService
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

    // @todo: Test this, also curious to see how it reacts when adding an item, which gets the 'correct' position
    // @todo -      Will it be the new item or the pre-existing item
    private function reorderMenuItems(BilingualMenuItem $data)
    {
        $menuItems = $this->adminRepo->getAllMenuItemsByCategory($data->categoryId);

        if($menuItems !== false) {
            $index = 1;
            foreach ($menuItems as $key => $menuItem) {
                if ($menuItem->position !== $index) {
                    $menuItem->setPosition($index);
                    if(!$this->adminRepo->patchMenuItem($menuItem)) {
                        $this->message->addWarning('Was an error updating menu item with caption: '
                            . $menuItem->getCaption());
                    }
                }
            }
        } else {
            $this->message->addWarning('Failed to get menu items by category, therefore couldn\'t reorder');
        }



        return $menuItems;
    }

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