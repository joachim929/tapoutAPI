<?php

// Objects

require_once __DIR__ . '/../../Objects/Events/AdminEventCategory.php';
require_once __DIR__ . '/../../Objects/Events/AdminEventItem.php';
require_once __DIR__ . '/../../Objects/Events/EventCategory.php';
require_once __DIR__ . '/../../Objects/Events/EventItem.php';
require_once __DIR__ . '/../../Objects/Shared/Response.php';

// Repos
require_once __DIR__ . '/../../Repository/Events/EventReadRepository.php';

// Services
require_once __DIR__ . '/../Shared/SortingService.php';

class ReadService
{

    // Repos

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

    public function __construct()
    {
        // Repos
        $this->readRepo = new EventReadRepository();

        // Services
        $this->sortingService = new SortingService();

        // Variables
        $this->response = new Response();
    }

    public function getAdminEvents()
    {
        $results = $this->readRepo->getAllEvents();

        if ($results !== false && $results !== []) {
            $sortedResults = $this->sortingService->removeArrayKeys($results);
            $this->response->setData($sortedResults);
            $this->response->setSuccess(true);
        } else {
            $this->response->setSuccess(false);
        }

        return $this->response;
    }

    public function getGuestEvents(string $language)
    {
        $results = $this->readRepo->getEventsByLanguage($language);

        if ($results !== false && $results !== []) {
            $this->sortGuestEvents($results, $language);
        } else {
            $this->response->setSuccess(false);
        }

        return $this->response;
    }

    private function sortGuestEvents(array $unsortedEvents, string $language)
    {
        $sortedResults = [];
        foreach ($unsortedEvents as $unsortedEvent) {
            $item = $this->setEventItem($unsortedEvent);

            if (!isset($sortedResults[$unsortedEvent['categoryId']])) {
                $sortedResults[$unsortedEvent['categoryId']] = $this->setCategoryItem($unsortedEvent, $language);
            }
            $sortedResults[$unsortedEvent['categoryId']]->addItem($item);

        }
        $results = $this->sortingService->removeArrayKeys($sortedResults);

        $this->response->setData($results);
        $this->response->setSuccess(true);
    }

    private function setCategoryItem(array $item, string $language)
    {
        if ($language === 'en') {
            $category = new EventCategory(
                $item['categoryEnName'],
                $item['categoryType'],
                $item['pagePosition'],
                $item['categoryId']
            );
        } else {
            $category = new EventCategory(
                $item['categoryVnName'],
                $item['categoryType'],
                $item['pagePosition'],
                $item['categoryId']
            );
        }

        return $category;
    }

    private function setEventItem(array $item)
    {
        return new EventItem(
            $item['categoryId'],
            $item['title'],
            $item['categoryPosition'],
            $item['start'],
            $item['end'],
            $item['itemId'],
            $item['description'],
            $item['usesStartTime'],
            $item['usesEndTime'],
            $item['usesEndDate']
        );
    }

}
