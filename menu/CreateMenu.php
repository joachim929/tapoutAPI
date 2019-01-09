<?php

// Repos

// Objects
require_once '../Objects/Menu/BilingualMenuItem.php';

// Services
require_once '../Services/Menu/CreateMenuItem.php';

class CreateMenu
{
    // Variables
    private $message;

    private $data;

    // Services
    private $createItemService;

    function __construct()
    {
        $this->createItemService = new CreateMenuItem;
        $this->message = [];
    }

    public function returnStatement()
    {
        $this->checkParams();
        if($this->message !== []) {
            echo json_encode($this->message);
        } else {
            echo (true);
        }
    }

    /**
     * This function makes sure all post params are good and if that is the case,
     * calls the create menu service
     */
    private function checkParams()
    {
        if ($this->checktask() && $this->checkPage() && $this->checkNewItem()) {
            $result = $this->createItemService->addNewItem($this->data);
            if(count($result) > 0) {
                foreach($result as $message) {
                    $this->message[] = $message;
                }
            }
        }
    }

    /**
     * This function checks that page param is set and the correct value
     * @return bool
     */
    private function checkPage(): bool
    {
        $check = true;
        if(isset($_POST['page'])) {
            $page = $_POST['page'];
            if($page !== 'Menu') {
                $check = false;
                $this->message[] = [
                    'error' => 'Invalid page given'
                ];
            }
        } else {
            $check = false;
            $this->message[] = [
                'error' => 'Page not set'
            ];
        }

        return $check;
    }

    /**
     * This function checks that the page task is of expected value
     * @return bool
     */
    private function checkTask(): bool
    {
        $check = true;
        if(isset($_POST['task'])) {
            $task = $_POST['task'];
            if($task !== 'createMenuItem') {
                $check = false;
                $this->message[] = [
                    'error' => 'Invalid task given'
                ];
            }
        } else {
            $check = false;
            $this->message[] = [
                'error' => 'Page not set'
            ];
        }

        return $check;
    }

    /**
     * This function checks all expected post parameters and returns a value on its findings
     * @return bool
     */
    private function checkNewItem(): bool
    {
        $check = true;
        if(isset($_POST['newMenuItem'])) {
            $this->data = json_decode($_POST['newMenuItem']);
        } else {
            $check = false;
            $this->message[] = [
                'error' => 'No item found in the expected place'
            ];
            $this->data = null;
        }
        if (!$this->checkNumber('category', $this->data->category)) {
            $check = false;
        }
        if (!$this->checkString('caption', $this->data->caption)) {
            $check = false;
        }
        if (!$this->checkString('English Title', $this->data->enTitle)) {
            $check = false;
        }
        if (!$this->checkString('Vietnamese Title', $this->data->vnTitle)) {
            $check = false;
        }
        if (!$this->checkNumber('category position', $this->data->categoryPosition)) {
            $check = false;
        }
        if (!$this->checkString('price', $this->data->price)) {
            $check = false;
        }
        if (!$this->checkDescriptions($this->data->enDescription, $this->data->vnDescription)) {
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks that the type of english/vietnamese descriptions match, if its a string it needs to
     * be >= 4 in length, creates error messages describing what went wrong if anything did go wrong
     * @param $enDescription
     * @param $vnDescription
     * @return bool
     */
    private function checkDescriptions($enDescription, $vnDescription)
    {
        $check = true;
        if (isset($enDescription, $vnDescription)) {
            if (!(is_string($enDescription) && is_string($vnDescription))) {
                $check = false;
                $this->message[] = [
                    'error' => 'English and Vietnamese descriptions need to be strings'
                ];
            } else {
                if(strlen($enDescription) < 4) {
                    $check = false;
                    $this->message[] = [
                        'error' => 'English description is too short'
                    ];
                }
                if(strlen($vnDescription) < 4) {
                    $check = false;
                    $this->message[] = [
                        'error' => 'Vietnamese description is too short'
                    ];
                }
            }
        } elseif (!isset($enDescription) && isset($vnDescription)) {
            $check = false;
            $this->message[] = [
                'error' => 'Only got a value for Vietnamese description, not English description'
            ];
        } elseif (!isset($vnDescription) && isset($enDescription)) {
            $check = false;
            $this->message[] = [
                'error' => 'Only got a value for English description, not Vietnamese description'
            ];
        }
        return $check;
    }

    /**
     * This function makes sure that a value is set and a string, if it isn't it creates an error message
     * @param string $type
     * @param        $value
     * @return bool
     */
    private function checkString(string $type, $value): bool
    {
        $check = true;
        if (!isset($value)) {
            $check = false;
            $this->message[] = [
                'error' => "No value for $type given"
            ];
        } elseif (!is_string($value)) {
            $check = false;
            $this->message[] = [
                'error' => "No valid value given for $value"
            ];
        }

        return $check;
    }

    /**
     * This function makes sure that a value is set and an int, if it isn't it creates an error message
     * @param string $type
     * @param        $value
     * @return bool
     */
    private function checkNumber(string $type, $value): bool
    {
        $check = true;
        if (!isset($value)) {
            $check = false;
            $this->message[] = [
                'error' => "No value for $type given"
            ];
        } elseif (!is_int($value)) {
            $check = false;
            $this->message[] = [
                'error' => "No valid value given for $value"
            ];
        }

        return $check;
    }
}