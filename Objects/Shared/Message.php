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
        foreach ($message->additional as $additional) {
            $this->addAdditional($additional);
        }

        foreach ($message->errors as $error) {
            $this->addError($error);
        }

        foreach ($message->warnings as $warning) {
            $this->addWarning($warning);
        }
    }

}