<?php

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Shared/Message.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuReadRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuUpdateItemRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class MenuUpdateItemService
{

    // Services

    /**
     * @var SortingService
     */
    private $sortingService;

    // Repos
    /**
     * @var MenuReadRepository
     */
    private $readRepo;
    /**
     * @var MenuUpdateItemRepository
     */
    private $updateRepo;

    // Variables
    /**
     * @var BilingualMenuItem
     */
    private $item;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var Response
     */
    private $response;

    public function __construct ()
    {

        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->readRepo = new MenuReadRepository();
        $this->updateRepo = new MenuUpdateItemRepository();

        //Variables
        $this->message = new Message();
        $this->response = new Response();
    }

    public function updateItem (BilingualMenuItem $item)
    {

        $this->item = $item;
    }

    private function checkPosition ()
    {

        $positionItems = $this->readRepo->getItemsByCategoryAndPosition($this->item->categoryId, $this->item->position);
        if ($positionItems === false) {
            $this->message->addWarning('Something went wrong checking other item\'s category position');
        } elseif ($positionItems === []) {

        }
    }

    private function updatePosition ()
    {

    }

}