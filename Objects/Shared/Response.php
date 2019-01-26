<?php

// Objects
require_once __DIR__ . '/../../Objects/Shared/Message.php';

/**
 * Class Response
 */
class Response
{

    public $data;

    /**
     * @var boolean
     */
    public $success;

    /**
     * @return mixed
     */
    public function getData ()
    {

        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData ($data)
    {

        $this->data = $data;
    }

    /**
     * @param $data
     */
    public function addData ($data)
    {

        $this->data[] = $data;
    }

    /**
     * @return bool
     */
    public function isSuccess () : bool
    {

        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess (bool $success)
    {

        $this->success = $success;
    }

    /**
     * This function merges two Response objects
     * @param Response $response
     */
    public function mergeResponse (Response $response)
    {

        if (isset($this->success)) {
            if ($this->success === true) {
                $this->setSuccess($response->success);
            }
        } elseif (isset($response->success)) {
            $this->setSuccess($response->success);
        }

        if (isset($this->data)) {
            $this->addData($response->data);
        } else {
            $this->setData($response->data);
        }
    }
}