<?php
require_once __DIR__ . '/../../ConnectDb.php';

// Services
require_once __DIR__ . '/../SortingService.php';

// Objects

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuRepository.php';

class BilingualMenuService
{
    // Services
    private $sortingService;

    // Repos
    private $menuRepo;

    /**
     * @var ConnectDb|null
     */
    private $conn;

    /**
     * @var mysqli
     */
    private $mysqli;

    private $connectDb;

    function __construct()
    {
        // Database connection
        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();

        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->menuRepo = new MenuRepository();
    }

    public function getMenu()
    {
        $rawResults = $this->menuRepo->newGetBilingualMenu();
        return $this->sortingService->removeArrayKeys($rawResults);
    }
}