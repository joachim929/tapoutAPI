<?php

class Message
{

    /**
     * @var array
     */
    public $errors;

    /**
     * @var array
     */
    public $warnings;

    /**
     * @var array
     */
    public $additional;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @param string $error
     */
    public function addError(string $error)
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * @param array $warnings
     */
    public function setWarnings(array $warnings)
    {
        $this->warnings = $warnings;
    }

    /**
     * @param string $warning
     */
    public function addWarning(string $warning)
    {
        $this->warnings[] = $warning;
    }

    /**
     * @return array
     */
    public function getAdditional(): array
    {
        return $this->additional;
    }

    /**
     * @param array $additional
     */
    public function setAdditional(array $additional)
    {
        $this->additional = $additional;
    }

    /**
     * @param string $additional
     */
    public function addAdditional(string $additional)
    {
        $this->additional[] = $additional;
    }

    /**
     * This function merges another Message object with the current Message Object
     * @param Message $message
     */
    public function mergeMessages(Message $message)
    {
        if($message->hasMessage()) {
            $this->mergeAdditional($message);
            $this->mergeErrors($message);
            $this->mergeWarnings($message);
        }
    }

    public function hasMessage()
    {
        $check = false;

        if(isset($this->warnings) && count($this->warnings) > 0) {
            $check = true;
        }
        if(isset($this->additional) && count($this->additional) > 0) {
            $check = true;
        }
        if(isset($this->errors) && count($this->errors) > 0) {
            $check = true;
        }


        return $check;
    }

    private function mergeAdditional(Message $message) {
        if (isset($message->additional) && count($message->additional) > 0) {
            foreach ($message->additional as $additional) {
                $this->addAdditional($additional);
            }
        }
    }

    private function mergeErrors(Message $message) {
        if (isset($message->errors) && count($message->errors) > 0) {
            foreach ($message->errors as $error) {
                $this->addError($error);
            }
        }
    }

    private function mergeWarnings(Message $message){
        if (isset($message->warnings) && count($message->warnings) > 0) {
            foreach ($message->warnings as $warnings) {
                $this->addWarning($warnings);
            }
        }
    }
}