<?php

// Objects

require_once __DIR__ . '/../../Objects/Events/BilingualEventCategory.php';
require_once __DIR__ . '/../../Objects/Events/BilingualEventItem.php';
require_once __DIR__ . '/../../Objects/Events/EventCategory.php';
require_once __DIR__ . '/../../Objects/Events/EventItem.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Events/EventReadRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class ReadService
{
    // Repos

    /**
     * @var EventReadRepository
     */
    private $readRepo;


    // Services

    /**
     * @var SortingService
     */
    private $sortingService;


    // Variables

    /**
     * @var Response
     */
    private $response;

    public function __construct()
    {
        // Repos
        $this->readRepo = new EventReadRepository();

        // Services
        $this->sortingService = new SortingService();

        // Variables
        $this->response = new Response();
    }

}
