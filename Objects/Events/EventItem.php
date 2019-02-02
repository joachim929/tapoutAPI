<?php

class EventItem
{

    /**
     * @var ?int
     */
    public $id;

    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var string
     */
    public $heading;

    /**
     * @var ?string
     */
    public $description;

    /**
     * @var string
     */
    public $language;

    /**
     * @var int
     */
    public $categoryPosition;

    /**
     * @var DateTime
     */
    public $startDate;

    /**
     * @var ?DateTime
     */
    public $endDate;

    /**
     * @var ?DateTime
     */
    public $startTime;

    /**
     * @var ?DateTime
     */
    public $endTime;

    /**
     * @var ?DateTime
     */
    public $createdAt;

    /**
     * @var ?DateTime
     */
    public $editedAt;

    public function __construct (int $categoryId, string $heading, ?string $description, ?string $language,
                                 int $categoryPosition, ?DateTime $startDate, ?int $id, ?DateTime $createdAt, ?DateTime $editedAt, ?DateTime $startTime, ?DateTime $endTime)
    {

        $this->setCategoryId($categoryId);
        $this->setHeading($heading);
        $this->setDescription($description);
        $this->setLanguage($language);
        $this->setCategoryPosition($categoryPosition);
        $this->setStartDate($startDate);
        $this->setId($id);
        $this->setCreatedAt($createdAt);
        $this->setEditedAt($editedAt);
        $this->setStartTime($startTime);
        $this->setEndTime($endTime);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getHeading() : string
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     */
    public function setHeading(string $heading)
    {
        $this->heading = $heading;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
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
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime)
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
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
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
