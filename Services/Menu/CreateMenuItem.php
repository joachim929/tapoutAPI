<?php
// Services
require_once __DIR__ . '/../Shared/SortingService.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Shared/Message.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuAdminRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuGuestRepository.php';

class CreateMenuItem
{

    // Services
    private $sortingService;

    // Repos
    /**
     * @var MenuAdminRepository
     */
    private $adminRepo;
    /**
     * @var MenuGuestRepository
     */
    private $guestRepo;

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
        $this->guestRepo = new MenuGuestRepository();

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
        } else {
            $this->message->addError('Failed to insert menu item');
        }
        $this->response->setData($data);
        $this->response->setMessage($this->message);
        return $this->response;
    }

    private function addNewItemDetails(BilingualMenuItem $data)
    {
        $enItemId = $this->adminRepo->newItemDetails($data->itemId, $data->enTitle,
            $data->enDescription, 'en');
        if($enItemId === false) {
            $this->message->addError('Failed to insert English menu item details');
        } else {
            $data->setEnId($enItemId);

            $vnItemId = $this->adminRepo->newItemDetails($data->itemId, $data->vnTitle,
                $data->vnDescription, 'vn');

            if($vnItemId === false) {
                $this->message->addError('Failed to insert Vietnamese menu item details');
            } else {
                $data->setVnId($vnItemId);
                $this->response->setSuccess(true);
            }
        }
    }

}