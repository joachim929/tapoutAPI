<?php

class BilingualItem
{
    /**
     * @var int
     */
    public $pageId;

    /**
     * @var int
     */
    public $pagePosition;

    /**
     * @var string
     */
    public $enHeading;

    /**
     * @var string
     */
    public $enContent;

    /**
     * @var string
     */
    public $vnHeading;

    /**
     * @var string
     */
    public $vnContent;

    /**
     * @var string|null
     */
    public $tag;

    /**
     * @var int| null
     */
    public $enItemId;

    /**
     * @var int|null
     */
    public $vnItemId;

    /**
     * @var ?DateTime
     */
    public $createdAt;

    /**
     * @var ?DateTime
     */
    public $editedAt;

    /**
     * @return int
     */
    public function getPageId(): int
    {
        return $this->pageId;
    }

    /**
     * @param int $pageId
     */
    public function setPageId(int $pageId)
    {
        $this->pageId = $pageId;
    }

    /**
     * @return int
     */
    public function getPagePosition(): int
    {
        return $this->pagePosition;
    }

    /**
     * @param int $pagePosition
     */
    public function setPagePosition(int $pagePosition)
    {
        $this->pagePosition = $pagePosition;
    }

    /**
     * @return string
     */
    public function getEnHeading(): string
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
     * @return string
     */
    public function getEnContent(): string
    {
        return $this->enContent;
    }

    /**
     * @param string $enContent
     */
    public function setEnContent(string $enContent)
    {
        $this->enContent = $enContent;
    }

    /**
     * @return string
     */
    public function getVnHeading(): string
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
     * @return string
     */
    public function getVnContent(): string
    {
        return $this->vnContent;
    }

    /**
     * @param string $vnContent
     */
    public function setVnContent(string $vnContent)
    {
        $this->vnContent = $vnContent;
    }

    /**
     * @return null|string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param null|string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return int|null
     */
    public function getEnItemId()
    {
        return $this->enItemId;
    }

    /**
     * @param int|null $enItemId
     */
    public function setEnItemId($enItemId)
    {
        $this->enItemId = $enItemId;
    }

    /**
     * @return int|null
     */
    public function getVnItemId()
    {
        return $this->vnItemId;
    }

    /**
     * @param int|null $vnItemId
     */
    public function setVnItemId($vnItemId)
    {
        $this->vnItemId = $vnItemId;
    }

    /**
     * @return dateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param dateTime|null $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return dateTime|null
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * @param dateTime|null $editedAt
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;
    }
}