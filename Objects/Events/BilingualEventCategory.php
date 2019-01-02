<?php

class BilingualEventCategory
{
    /**
     * @var string
     */
    public $tag;

    /**
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $pagePosition;

    /**
     * @var array
     */
    public $eventItems;

    /**
     * @var int
     */
    public $enCatId;

    /**
     * @var string
     */
    public $enCatName;

    /**
     * @var int
     */
    public $vnCatId;

    /**
     * @var string
     */
    public $vnCatName;

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
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
     * @return array
     */
    public function getEventItems(): array
    {
        return $this->eventItems;
    }

    /**
     * @param array $eventItems
     */
    public function setEventItems(array $eventItems)
    {
        $this->eventItems = $eventItems;
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
    public function getEnCatName(): string
    {
        return $this->enCatName;
    }

    /**
     * @param string $enCatName
     */
    public function setEnCatName(string $enCatName)
    {
        $this->enCatName = $enCatName;
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
    public function getVnCatName(): string
    {
        return $this->vnCatName;
    }

    /**
     * @param string $vnCatName
     */
    public function setVnCatName(string $vnCatName)
    {
        $this->vnCatName = $vnCatName;
    }
}