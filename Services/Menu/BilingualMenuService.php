<?php
// Services
require_once __DIR__ . '/../SortingService.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuRepository.php';

class BilingualMenuService
{
    // Services
    private $sortingService;

    // Repos
    private $menuRepo;

    function __construct()
    {
        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->menuRepo = new MenuRepository();
    }

    public function getMenu()
    {
        $rawResults = $this->menuRepo->getBilingualMenu();
        return $this->sortingService->removeArrayKeys($rawResults);
    }
}