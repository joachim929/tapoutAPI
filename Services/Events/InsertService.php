<?php

// Objects

require_once __DIR__ . '/../../Objects/Events/AdminEventCategory.php';
require_once __DIR__ . '/../../Objects/Events/AdminEventItem.php';
require_once __DIR__ . '/../../Objects/Events/EventCategory.php';
require_once __DIR__ . '/../../Objects/Events/EventItem.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Events/EventInsertRepository.php';
require_once __DIR__ . '/../../Repository/Events/EventPatchRepository.php';
require_once __DIR__ . '/../../Repository/Events/EventReadRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class InsertService
{

    // Repos

    /**
     * @var EventInsertRepository
     */
    private $insertRepo;
    /**
     * @var EventPatchRepository
     */
    private $patchRepo;
    /**
     * @var EventReadRepository
     */
    private $readRepo;

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
    /**
     * @var AdminEventItem
     */
    private $item;

    /**
     * @var AdminEventCategory
     */
    private $category;

    public function __construct()
    {
        // Repos
        $this->insertRepo = new EventInsertRepository();
        $this->patchRepo = new EventPatchRepository();
        $this->readRepo = new EventReadRepository();

        // Services
        $this->sortingService = new SortingService();

        // Variables
        $this->response = new Response();
    }

    // todo:    Write item insert repo call
    // todo:    Check its status
    // todo:    Reorder category items
    // todo:    Write patch position repo call
    // todo:    Return item
    public function insertItem(AdminEventItem $postItem)
    {
        $this->item = $postItem;

        $category = $this->readRepo->getEventCategory($this->item->getCategoryId());

        if ($category !== false) {
            $newItem = $this->itemInsert();
            if ($newItem !== false) {
                $this->item = $newItem;
                $this->response->setData($this->item);
                $this->response->passed();
                $this->reorderCategoryItems($category->getItems());
            }
        } else {
            $this->response->failed();
        }

        return $this->response;
    }

    private function itemInsert()
    {
        $lastId = $this->prepItemInsert();
        $check = false;

        if($lastId !== false && is_int($lastId)) {
            $newItem = $this->readRepo->getEventItem($lastId);

            if ($newItem !== false) {
                $check = $newItem;

            }

        } else {
            $this->response->failed();

        }

        return $check;
    }

    private function prepItemInsert()
    {
        $check = false;
        $lastId = $this->insertRepo->insertItem($this->item);
        if ($lastId !== false && is_int($lastId)) {
            $this->item->setItemId($lastId);
            $detailsCheck = $this->insertRepo->insertItemDetails($this->item);
        } else {
            $check = false;
        }

        return $check;
    }

    private function reorderCategoryItems(array $categoryItems)
    {
        $position = 1;
        foreach ($categoryItems as $item) {
            if ($item->id === $this->item->itemId) {
                continue;
            }

            if ($position === $this->item->position) {
                $position++;
            }

            if ($position !== $item->position) {
                $item->setPosition($position);
                if (!$this->patchRepo->patchEventItemPosition($item)) {
                    break;
                }

            }
            $position++;
        }
    }


    public function insertCategory(AdminEventCategory $postCategory)
    {
        return $this->response;
    }

}
