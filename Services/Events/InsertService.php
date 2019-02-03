<?php

// Objects

require_once __DIR__ . '/../../Objects/Events/AdminEventCategory.php';
require_once __DIR__ . '/../../Objects/Events/AdminEventItem.php';
require_once __DIR__ . '/../../Objects/Events/EventCategory.php';
require_once __DIR__ . '/../../Objects/Events/EventItem.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Events/EventInsertRepository.php';
require_once __DIR__ . '/../../Repository/Events/EventPatchRepository.php';
require_once __DIR__ . '/../../Repository/Events/EventReadRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class InsertService
{
    // Repos

    /**
     * @var EventInsertRepository
     */
    private $insertRepo;
    /**
     * @var EventPatchRepository
     */
    private $patchRepo;
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
        $this->insertRepo = new EventInsertRepository();
        $this->patchRepo = new EventPatchRepository();
        $this->readRepo = new EventReadRepository();

        // Services
        $this->sortingService = new SortingService();

        // Variables
        $this->response = new Response();
    }

}
