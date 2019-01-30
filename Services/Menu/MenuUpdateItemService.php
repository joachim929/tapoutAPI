<?php

// Objects
require_once __DIR__ . '/../../Objects/Menu/BilingualMenuItem.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Menu/MenuReadRepository.php';
require_once __DIR__ . '/../../Repository/Menu/MenuUpdateItemRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class MenuUpdateItemService
{

    // Services

    /**
     * @var SortingService
     */
    private $sortingService;

    // Repos
    /**
     * @var MenuReadRepository
     */
    private $readRepo;

    /**
     * @var MenuUpdateItemRepository
     */
    private $updateRepo;

    // Variables
    /**
     * @var BilingualMenuItem
     */
    private $postedItem;

    /**
     * @var Response
     */
    private $response;

    public function __construct()
    {

        // Services
        $this->sortingService = new SortingService();

        // Repos
        $this->readRepo = new MenuReadRepository();
        $this->updateRepo = new MenuUpdateItemRepository();

        // Variables
        $this->response = new Response();
    }

    public function updateItem(BilingualMenuItem $item)
    {

        $this->postedItem = $item;

        $this->checkChanges();

        return $this->response;
    }

    private function changePosition()
    {

        $items = $this->readRepo->getItemsByCategory($this->postedItem->categoryId);

        $index = 1;
        foreach ($items as $item) {
            if ($item->id === $this->postedItem->itemId) {
                continue;
            }

            if ($index === $this->postedItem->position) {
                $index++;
            }

            if ($item->position !== $index) {
                if (!$this->updateRepo->patchMenuItemPosition($item->id, $item->position)) {
                }
            }

            $index++;

        }
    }

    /**
     * This function checks to see if more items need to be changed or not
     * If a position is changed then it needs to change other items positions so items there
     * aren't two items on the same position
     */
    private function checkChanges()
    {

        $oldItem = $this->readRepo->getitemById($this->postedItem->itemId);
        if ($oldItem->position !== $this->postedItem->position) {
            $this->changePosition();
        }
        $this->checkItemChanges($oldItem);

    }

    /**
     * This function calls patch functions if params have been changed
     * @param BilingualMenuItem $oldItem
     */
    private function checkItemChanges(BilingualMenuItem $oldItem)
    {

        $check = true;
        if ($this->hasItemDetailDifferences('en', $oldItem)) {

            if (!$this->updateRepo->patchMenuItemDetails($this->postedItem->enId,
                $this->postedItem->enTitle, $this->postedItem->enDescription)
            ) {

                $check = false;

            }
        }
        if ($this->hasItemDetailDifferences('vn', $oldItem)) {

            if (!$this->updateRepo->patchMenuItemDetails($this->postedItem->vnId,
                $this->postedItem->vnTitle, $this->postedItem->vnDescription)
            ) {
                $check = false;

            }
        }
        if ($this->hasItemDifferences($oldItem)) {
            if ($this->updateRepo->patchMenuItem($this->postedItem) === false) {
                $check = false;
            }
        }

        if ($check) {
            $this->response->setData($this->readRepo->getItemById($this->postedItem->itemId));
        }

        $this->response->setSuccess($check);
    }

    /**
     * This function checks whether the posted item details are the same as what is
     * currently in the database. It returns false if they have the same values
     * @param string            $language
     * @param BilingualMenuItem $oldItem
     * @return bool
     */
    private function hasItemDetailDifferences(string $language, BilingualMenuItem $oldItem)
    {

        $check = false;
        if ($language === 'en') {
            if ($this->postedItem->enDescription !== $oldItem->enDescription) {
                $check = true;
            }
            if ($this->postedItem->enTitle !== $oldItem->enTitle) {
                $check = true;
            }
        } elseif ($language === 'vn') {

            if ($this->postedItem->vnDescription !== $oldItem->vnDescription) {
                $check = true;
            }
            if ($this->postedItem->vnTitle !== $oldItem->vnTitle) {
                $check = true;
            }
        }

        return $check;
    }

    /**
     * This function checks the post params against what is in
     * the database and returns false if they have the same values
     * @param BilingualMenuItem $oldItem
     * @return bool
     */
    private function hasItemDifferences(BilingualMenuItem $oldItem)
    {

        $check = false;

        if ($oldItem->categoryId !== $this->postedItem->categoryId) {
            $check = true;
        }
        if ($oldItem->price !== $this->postedItem->price) {
            $check = true;
        }
        if ($oldItem->position !== $this->postedItem->position) {
            $check = true;
        }

        return $check;
    }

}