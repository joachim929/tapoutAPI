<?php

// Objects
require_once '../Objects/Shared/Response.php';
require_once '../Objects/Events/AdminEventCategory.php';
require_once '../Objects/Events/AdminEventItem.php';

// Services
require_once '../Services/Events/InsertService.php';
require_once '../Services/Shared/SortingService.php';

class CreateEvent
{

    // Services

    /**
     * @var InsertService
     */
    private $insertService;
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
     * @var string
     */
    private $task;

    public function __construct()
    {
        $this->insertService = new InsertService();
        $this->sortingService = new SortingService();

        $this->response = new Response();

    }

    public function returnStatement()
    {
        if (isset($_POST) && $this->checkPage() && $this->checkTask() && $this->checkModule()) {
            $this->routeRequest();
        } else {
            $this->response->setSuccess(false);
        }

        echo json_encode($this->response);
    }

    private function checkPage()
    {
        $check = false;

        if (isset($_POST['page'])) {
            $page = $_POST['page'];
            $check = $this->sortingService->checkPage($page);
        }

        return $check;
    }

    private function checkTask()
    {
        $check = false;

        if (isset($_POST['task'])) {
            $this->task = $_POST['task'];
            if ($this->task === 'createEventItem' || $this->task === 'createEventCategory') {
                $check = true;
            }
        }

        return $check;
    }

    private function routeRequest()
    {

        if (isset($_POST['item'])) {

            $item = json_decode($_POST['item']);

            if ($this->task === 'createEventItem') {

                $formattedItem = $this->checkItemParams($item);

                if ($formattedItem !== false) {

                    $item = new AdminEventItem($item->categoryId, $item->position, null, null,
                        null, null, $item->enTitle, $item->enDescription, null,
                        null, null, $item->vnTitle, $item->vnDescription, null,
                        null, $item->start, $item->end, $item->usesStartTime, $item->usesEndTime,
                        $item->usesEndDate, true);
                    $this->response = $this->insertService->insertItem($item);

                } else {
                    $this->response->setSuccess(false);
                }

            } elseif ($this->checkCategoryParams($item)) {

                $category = new AdminEventCategory(null, $item->enName, $item->vnName, $item->type,
                    $item->position, null, null, true);
                $this->response = $this->insertService->insertCategory($category);

            } else {
                $this->response->setSuccess(false);
            }
        }
    }

    private function checkItemParams($item)
    {
        $check = true;

        if (!$this->sortingService->checkNumber($item->categoryId)) {
            $check = false;
        }
        if (!$this->sortingService->checkNumber($item->position)) {
            $check = false;
        }
        if (!$this->sortingService->checkString($item->enTitle)) {
            $check = false;
        }
        if (!$this->sortingService->checkString($item->vnTitle)) {
            $check = false;
        }
        if (!$this->sortingService->checkDescriptions($item->enDescription, $item->vnDescription)) {
            $check = false;
        }
        $formattedTime = $this->checkTimeParams($item);
        if ($formattedTime === false) {
            $check = false;
        } elseif ($check === true) {
            $check = $formattedTime;
        }

        return $check;
    }

    private function checkTimeParams(array $item)
    {
        $formattedStartItem = $this->formatStartParams($item);
        if ($formattedStartItem === false) {
            $check = false;
        } else {
            $check = $this->formatEndParams($formattedStartItem);
        }

        return $check;
    }

    private function formatEndParams($item)
    {
        if ($this->sortingService->isValidTimeStamp($item->end)) {
            if (!isset($item->usesEndTime)) {
                $item->usesEndTime = false;
            }
            if (!isset($item->usesEndDate)) {
                $item->usesEndDate = false;
            }
            $check = $item;
        } else {
            $item->end = new DateTime();
            $item->usesEndDate = false;
            $item->usesEndTime = false;
            $check = $item;
        }

        return $check;
    }

    private function formatStartParams($item)
    {
        if ($this->sortingService->isValidTimeStamp($item->start)) {
            if (!isset($item->usesStartTime)) {
                $item->usesStartTime = false;
            }
        } else {
            $item = false;
        }

        return $item;
    }

    private function checkCategoryParams($category)
    {
        $check = true;

        if (!$this->sortingService->checkString($category->enName)) {
            $check = false;
        }
        if (!$this->sortingService->checkString($category->vnName)) {
            $check = false;
        }
        if (!$this->sortingService->checkString($category->type)) {
            $check = false;
        }
        if (!$this->sortingService->checkNumber($category->position)) {
            $check = false;
        }

        return $check;
    }

    private function checkModule()
    {
        $check = false;
        if (isset($_POST['module'])) {
            $module = $_POST['module'];

            $check = $this->sortingService->checkForAdminModule($module);
        }

        return $check;
    }
}
