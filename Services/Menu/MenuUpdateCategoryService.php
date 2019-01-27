<?php

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuCategory.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuCategoryRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class MenuUpdateCategoryService
{

    // Repos

    /**
     * @var MenuCategoryRepository
     */
    private $categoryRepo;

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

    public function __construct ()
    {

        // Repos
        $this->categoryRepo = new MenuCategoryRepository();

        // Services
        $this->sortingService = new SortingService();

        //Variables
        $this->response = new Response();
    }

    /**
     * @todo: Check category exists
     *      Then update position
     *      On success get items and return them
     */
    //

    /**
     * @param array $items
     * @return Response
     */
    public function updateCategoryPosition(array $items)
    {
        $this->checkCategories($items);
        return $this->response;
    }

    /**
     * @param BilingualMenuCategory[] $categories
     */
    private function checkCategories(array $categories)
    {
        $allCategories = $this->categoryRepo->getCategories();

        if($allCategories !== [] && count($categories) === 2) {
            foreach ($allCategories as $category) {
                if ($category->id === $categories[0]->id) {
                    $this->checkCategory($categories[0]);
                }
                if ($category->id === $categories[1]->id) {
                    $this->checkCategory($categories[1]);
                }
            }
        }

    }

    private function checkCategory(BilingualMenuCategory $category)
    {
        $check = true;

        if ($category->position < 1) {
            $category->setPosition(1);
        }

        $category = $this->categoryRepo->patchMenuCategory($category);
        if($category === false) {
            $this->response->setSuccess(false);
        } else {
            if(isset($this->response->success) && $this->response->success === false) {
                $this->response->addData($category);
            } else {
                $this->response->addData($category);
                $this->response->setSuccess(true);
            }
        }

        return $check;
    }

}