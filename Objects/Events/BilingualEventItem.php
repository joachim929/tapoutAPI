<?php

class BilingualEventItem
{

    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var int
     */
    public $categoryPosition;

    /**
     * @var ?int
     */
    public $itemId;

    /**
     * @var ?int
     */
    public $enId;

    /**
     * @var string
     */
    public $enHeading;

    /**
     * @var ?string
     */
    public $enDescription;

    /**
     * @var ?int
     */
    public $vnId;

    /**
     * @var string
     */
    public $vnHeading;

    /**
     * @var ?string
     */
    public $vnDescription;

    /**
     * @var DateTime
     */
    public $startTime;

    /**
     * @var ?DateTime
     */
    public $endTime;

    /**
     * @var DateTime
     */
    public $startDate;

    /**
     * @var ?DateTime
     */
    public $endDate;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var ?DateTime
     */
    public $editedAt;

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getCategoryId() : int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int
     */
    public function getCategoryPosition() : int
    {
        return $this->categoryPosition;
    }

    /**
     * @param int $categoryPosition
     */
    public function setCategoryPosition(int $categoryPosition)
    {
        $this->categoryPosition = $categoryPosition;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param mixed $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return mixed
     */
    public function getEnId()
    {
        return $this->enId;
    }

    /**
     * @param mixed $enId
     */
    public function setEnId($enId)
    {
        $this->enId = $enId;
    }

    /**
     * @return string
     */
    public function getEnHeading() : string
    {
        return $this->enHeading;
    }

    /**
     * @param string $enHeading
     */
    public function setEnHeading(string $enHeading)
    {
        $this->enHeading = $enHeading;
    }

    /**
     * @return mixed
     */
    public function getEnDescription()
    {
        return $this->enDescription;
    }

    /**
     * @param mixed $enDescription
     */
    public function setEnDescription($enDescription)
    {
        $this->enDescription = $enDescription;
    }

    /**
     * @return mixed
     */
    public function getVnId()
    {
        return $this->vnId;
    }

    /**
     * @param mixed $vnId
     */
    public function setVnId($vnId)
    {
        $this->vnId = $vnId;
    }

    /**
     * @return string
     */
    public function getVnHeading() : string
    {
        return $this->vnHeading;
    }

    /**
     * @param string $vnHeading
     */
    public function setVnHeading(string $vnHeading)
    {
        $this->vnHeading = $vnHeading;
    }

    /**
     * @return mixed
     */
    public function getVnDescription()
    {
        return $this->vnDescription;
    }

    /**
     * @param mixed $vnDescription
     */
    public function setVnDescription($vnDescription)
    {
        $this->vnDescription = $vnDescription;
    }

    /**
     * @return DateTime
     */
    public function getStartTime() : DateTime
    {
        return $this->startTime;
    }

    /**
     * @param DateTime $startTime
     */
    public function setStartTime(DateTime $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return DateTime
     */
    public function getStartDate() : DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt() : DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * @param mixed $editedAt
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;
    }
}
