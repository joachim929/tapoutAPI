<?php

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuCategoryRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuReadRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class MenuAdminReadService
{

    // Repos
    /**
     * @var MenuReadRepository
     */
    private $guestRepo;
    /**
     * @var MenuCategoryRepository
     */
    private $menuCatRepo;

    // Services
    /**
     * @var SortingService
     */
    private $sortingService;

    public function __construct()
    {
        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->guestRepo = new MenuReadRepository();
        $this->menuCatRepo = new MenuCategoryRepository();
    }

    public function getMenu()
    {
        $rawResults = $this->guestRepo->getBilingualMenu();
        return $this->sortingService->removeArrayKeys($rawResults);
    }

    public function getCategories()
    {
        return $this->menuCatRepo->getCategories();
    }

}