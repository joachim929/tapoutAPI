<?php
require_once '../ConnectDb.php';

// Objects
require_once '../Objects/Shared/Response.php';

// Services
require_once '../Services/Events/ReadService.php';

class ReadEvent
{
    // Services

    /**
     * @var ReadService
     */
    private $readService;

    // Variables

    /**
     * @var ConnectDb|null
     */
    private $conn;
    /**
     * @var mysqli
     */
    private $mysqli;
    /**
     * @var ConnectDb
     */
    private $connectDb;
    /**
     * @var Response
     */
    private $response;
    /**
     * @var string
     */
    private $task;
    /**
     * @var string
     */
    private $module;
    /**
     * @var string
     */
    private $lang;

    public function __construct()
    {
        $this->readService = new ReadService();

        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();

        $this->response = new Response();
    }

    /**
     * This function is the entry point of the class
     */
    public function returnStatement()
    {
        if ($this->checkPage() && $this->checkTask() && $this->checkModule() && $this->checkLanguage()) {
            $this->response = $this->routeRequest();
        } else {
            $this->response->setSuccess(false);
        }

        echo json_encode($this->response);
    }

    private function routeRequest()
    {
        $result = new Response;
        if ($this->module === 'Guest' && $this->task === 'read') {
            if (isset($this->lang)) {
                $result = $this->readService->getGuestEvents($this->lang);
            }
        } elseif ($this->module === 'Admin' && $this->task === 'edit') {
            $result = $this->readService->getAdminEvents();
        }  else {
            $result->setSuccess(false);
        }

        return $result;
    }

    private function checkTask()
    {
        $check = true;
        if (isset($_GET['task'])) {
            $this->task = $_GET['task'];
            if (!is_string($this->task)) {
                $check = false;
            } else {
                if ($this->task !== 'read' && $this->task !== 'edit') {
                    $check = false;
                }
            }
        } else {
            $check = false;
        }

        return $check;
    }

    private function checkModule()
    {
        $check = true;
        if (isset($_GET['module'])) {
            $this->module = $_GET['module'];
            if ($this->module !== 'Guest' && $this->module !== 'Admin') {
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }

    private function checkPage()
    {
        $check = true;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page !== 'Events') {
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }

    private function checkLanguage()
    {
        $check = true;
        if (isset($_GET['lang'])) {
            $this->lang = $_GET['lang'];

            if ($this->lang !== 'en' && $this->lang !== 'vn') {
                $check = false;
            }
        }

        return $check;
    }
}
