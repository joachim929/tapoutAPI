<?php

class BilingualEventItem
{
    /**
     * @var string
     */
    var $tag;

    /**
     * @var DateTime
     */
    var $startTime;

    /**
     * @var DateTime
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

    /**
     * @var int
     */
    var $categoryPosition;

    /**
     * @var int
     */
    var $vnItemId;

    /**
     * @var int
     */
    var $vnCatId;

    /**
     * @var string
     */
    var $vnItemHeading;

    /**
     * @var string
     */
    var $vnItemDescription;

    /**
     * @var int
     */
    var $enItemId;

    /**
     * @var int
     */
    var $enCatId;

    /**
     * @var string
     */
    var $enItemHeading;

    /**
     * @var string
     */
    var $enItemDescription;

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
     * @return int
     */
    public function getVnItemId(): int
    {
        return $this->vnItemId;
    }

    /**
     * @param int $vnItemId
     */
    public function setVnItemId(int $vnItemId)
    {
        $this->vnItemId = $vnItemId;
    }

    /**
     * @return int
     */
    public function getVnCatId(): int
    {
        return $this->vnCatId;
    }

    /**
     * @param int $vnCatId
     */
    public function setVnCatId(int $vnCatId)
    {
        $this->vnCatId = $vnCatId;
    }

    /**
     * @return string
     */
    public function getVnItemHeading(): string
    {
        return $this->vnItemHeading;
    }

    /**
     * @param string $vnItemHeading
     */
    public function setVnItemHeading(string $vnItemHeading)
    {
        $this->vnItemHeading = $vnItemHeading;
    }

    /**
     * @return string
     */
    public function getVnItemDescription(): string
    {
        return $this->vnItemDescription;
    }

    /**
     * @param string $vnItemDescription
     */
    public function setVnItemDescription(string $vnItemDescription)
    {
        $this->vnItemDescription = $vnItemDescription;
    }

    /**
     * @return int
     */
    public function getEnItemId(): int
    {
        return $this->enItemId;
    }

    /**
     * @param int $enItemId
     */
    public function setEnItemId(int $enItemId)
    {
        $this->enItemId = $enItemId;
    }

    /**
     * @return int
     */
    public function getEnCatId(): int
    {
        return $this->enCatId;
    }

    /**
     * @param int $enCatId
     */
    public function setEnCatId(int $enCatId)
    {
        $this->enCatId = $enCatId;
    }

    /**
     * @return string
     */
    public function getEnItemHeading(): string
    {
        return $this->enItemHeading;
    }

    /**
     * @param string $enItemHeading
     */
    public function setEnItemHeading(string $enItemHeading)
    {
        $this->enItemHeading = $enItemHeading;
    }

    /**
     * @return string
     */
    public function getEnItemDescription(): string
    {
        return $this->enItemDescription;
    }

    /**
     * @param string $enItemDescription
     */
    public function setEnItemDescription(string $enItemDescription)
    {
        $this->enItemDescription = $enItemDescription;
    }
}