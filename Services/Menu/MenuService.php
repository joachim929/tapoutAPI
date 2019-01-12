<?php
// Services
require_once __DIR__ . '/../Shared/SortingService.php';

// Objects

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuRepository.php';

class MenuService
{
    // Services
    private $sortingService;

    //Repos
    private $menuRepo;

    public function __construct()
    {
        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->menuRepo = new MenuRepository();
    }

    public function getMenu($language)
    {
        $results = $this->menuRepo->getMenuByLanguage($language);
        return $this->sortingService->removeArrayKeys($results);
    }
}