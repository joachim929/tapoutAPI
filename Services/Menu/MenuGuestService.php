<?php

// Objects

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuReadRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class MenuGuestService
{

    //Repos
    private $guestRepo;

    // Services
    private $sortingService;

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