<?php

class EventItem
{
    /**
     * @var int
     */
    var $id;

    /**
     * @var int
     */
    var $categoryId;

    /**
     * @var string
     */
    var $heading;

    /**
     * @var string
     */
    var $description;

    /**
     * @var string
     */
    var $language;

    /**
     * @var string
     */
    var $tag;

    /**
     * @var int
     */
    var $categoryPosition;

    /**
     * @var DateTime::format('H:i:s')
     */
    var $startDate;

    /**
     * @var DateTime::format('H:i:s')
     */
    var $startTime;

    /**
     * @var DateTime::format('H:i:s')
     */
    var $endTime;

    /**
     * @var DateTime
     */
    var $createdAt;

    /**
     * @var DateTime
     */
    var $editedAt;

    function __construct($categoryId, $heading, $description, $language, $tag, $categoryPosition, $startDate,
                         $id = null, $createdAt = null, $editedAt = null, $startTime = null, $endTime = null)
    {
        $this->setCategoryId($categoryId);
        $this->setHeading($heading);
        $this->setDescription($description);
        $this->setLanguage($language);
        $this->setTag($tag);
        $this->setCategoryPosition($categoryPosition);
        $this->setStartDate($startDate);

        if($id !== null) {
            $this->setId($id);
        }

        if($createdAt !== null) {
            $this->setCreatedAt($createdAt);
        }

        if($editedAt !== null) {
            $this->setEditedAt($editedAt);
        }

        if($startTime !== null) {
            $this->setStartTime($startTime);
        }

        if($endTime !== null) {
            $this->setEndTime($endTime);
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
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
    public function getHeading(): string
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
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
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return int
     */
    public function getCategoryPosition(): int
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
    public function getStartDate(): DateTime
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
     * @return DateTime
     */
    public function getStartTime(): DateTime
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
     * @return DateTime
     */
    public function getEndTime(): DateTime
    {
        return $this->endTime;
    }

    /**
     * @param DateTime $endTime
     */
    public function setEndTime(DateTime $endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
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
     * @return DateTime
     */
    public function getEditedAt(): DateTime
    {
        return $this->editedAt;
    }

    /**
     * @param DateTime $editedAt
     */
    public function setEditedAt(DateTime $editedAt)
    {
        $this->editedAt = $editedAt;
    }
}