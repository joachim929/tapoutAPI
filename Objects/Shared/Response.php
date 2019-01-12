<?php

require_once __DIR__ . '/../../Objects/Shared/Message.php';

class Response
{

    public $data;

    /**
     * @var Message
     */
    public $message;

    /**
     * @var boolean
     */
    public $success;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function addData($data)
    {
        $this->data[] = $data;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    /**
     * This function merges two Response objects
     * @param Response $response
     */
    public function mergeResponse(Response $response)
    {
        if ($this->success === true) {
            $this->setSuccess($response->success);
        }
        if (isset($this->data)) {
            $this->addData($response->data);
        } else {
            $this->setData($response->data);
        }

        if ($this->hasMessages()) {
            $this->message->mergeMessages($response->message);
        } else {
            $this->setMessage($response->message);
        }
    }

    /**
     * This function checks if Message has any messages
     * @return bool
     */
    public function hasMessages()
    {
        $check = false;
        if (isset($this->message)) {
            $check = true;
        }
        if (isset($this->message)) {
            $check = true;
        }
        if (isset($this->message)) {
            $check = true;
        }

        return $check;
    }

}