<?php
// Services
require_once __DIR__ . '/../Shared/SortingService.php';

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Shared/Message.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuAdminRepository.php';

class CreateMenuCategoryService
{

    // Services

    /**
     * @var SortingService
     */
    private $sortingService;

    // Repos
    /**
     * @var MenuAdminRepository
     */
    private $adminRepo;

    // Variables
    /**
     * @var Message
     */
    private $message;

    /**
     * @var Response
     */
    private $response;

    public function __construct()
    {
        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->adminRepo = new MenuAdminRepository();

        //Variables
        $this->message = new Message();
        $this->response = new Response();
    }

    public function addNewCategory(BilingualMenuCategory $data)
    {
        $categoryId = $this->adminRepo->newCategory($data);

        if ($categoryId !== 'false') {

        }

        return $this->response;
    }

    private function reorderCategories()
    {

    }
}