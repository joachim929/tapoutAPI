<?php
// Services
require_once __DIR__ . '/../Shared/SortingService.php';

// Objects

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuReadRepository.php';

class GuestReadMenuService
{
    // Services
    private $sortingService;

    //Repos
    private $guestRepo;

    public function __construct()
    {
        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->guestRepo = new MenuReadRepository();
    }

    public function getMenu($language)
    {
        $results = $this->guestRepo->getMenuByLanguage($language);
        return $this->sortingService->removeArrayKeys($results);
    }
}