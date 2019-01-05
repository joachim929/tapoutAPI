<?php
// Services
require_once __DIR__ . '/../SortingService.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuCategoryRepository.php';

class BilingualMenuService
{
    // Services
    private $sortingService;

    // Repos
    private $menuRepo;
    private $menuCatRepo;

    function __construct()
    {
        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->menuRepo = new MenuRepository();
        $this->menuCatRepo = new MenuCategoryRepository();
    }

    public function getMenu()
    {
        $rawResults = $this->menuRepo->getBilingualMenu();
        return $this->sortingService->removeArrayKeys($rawResults);
    }

    public function getCategories()
    {
        return $this->menuCatRepo->getCategories();
    }
}