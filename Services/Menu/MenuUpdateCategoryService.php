<?php

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class MenuUpdateCategoryService
{

    // Services

    /**
     * @var SortingService
     */
    private $sortingService;

    // Variables
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

        //Variables
        $this->response = new Response();
    }

}