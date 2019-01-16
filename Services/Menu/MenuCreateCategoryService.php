<?php

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Shared/Message.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuAdminRepository.php';

class MenuCreateCategoryService
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

    /**
     * This function adds a new category to the database
     * @param BilingualMenuCategory $data
     * @return Response
     */
    public function addNewCategory(BilingualMenuCategory $data)
    {
        $categoryId = $this->adminRepo->newCategory($data);
        $newCategory = $data;

        if (is_int($categoryId)) {
            $data->setId($categoryId);
            $newCategory = $this->reorderCategories($data);
        } else {
            $this->message->addError('Failed inserting new category');
        }
        if ($newCategory === false) {
            $this->response->setData($data);
        } else {
            $this->response->setData($newCategory);
        }
        $this->response->setMessage($this->message);
        return $this->response;
    }

    /**
     * @todo: Fix so that if a newly assigned item has been added that it retains the page position,
     * @todo -      older items should all move up one position
     * This function reorders all menu categories if their position doesn't line up with their index
     * @param BilingualMenuCategory $data
     * @return BilingualMenuCategory|bool
     */
    private function reorderCategories(BilingualMenuCategory $data)
    {
        $categories = $this->adminRepo->getAllCategories();
        $newCategory = false;

        if ($categories === false) {
            $this->message->addWarning('Failed to get categories to re-order');
        } else {
            $index = 1;
            foreach ($categories as $category) {
                if($category->position !== $index) {
                    $category->setPosition($index);
                    if (!$this->adminRepo->patchCategoryPosition($category)) {
                        $this->message->addWarning('Failed to update category position with name: ' .
                        $category->enName);
                    }
                }
                if ($data->id === $category->id) {
                    $newCategory = $category;
                }
                $index++;
            }
        }
        if ($newCategory !== false) {
            $this->response->setSuccess(true);
        }

        return $newCategory;
    }
}