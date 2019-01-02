<?php

require_once __DIR__ . './BilingualMenuItem.php';

class BilingualMenuCategory
{
    /**
     * @var string
     */
    public $categoryTag;

    /**
     * @var int
     */
    public $enCategoryId;

    /**
     * @var string
     */
    public $enCategoryName;

    /**
     * @var int
     */
    public $vnCategoryId;

    /**
     * @var string
     */
    public $vnCategoryName;

    /**
     * @var int
     */
    public $position;

    /**
     * @var string
     */
    public $categoryType;

    /**
     * @var array
     */
    public $items;

    function __construct($tag, $position, $type)
    {
        $this->setDetails($tag, $position, $type);
    }

    public function setEnglish($id, $name)
    {
        $this->setEnCategoryId($id);
        $this->setEnCategoryName($name);
    }

    public function setVietnamese($id, $name)
    {
        $this->setVnCategoryId($id);
        $this->setVnCategoryName($name);
    }

    public function setDetails($tag, $position, $type)
    {
        $this->setCategoryTag($tag);
        $this->setPosition($position);
        $this->setCategoryType($type);
    }

    /**
     * @return string
     */
    public function getCategoryTag(): string
    {
        return $this->categoryTag;
    }

    /**
     * @param string $categoryTag
     */
    public function setCategoryTag(string $categoryTag)
    {
        $this->categoryTag = $categoryTag;
    }

    /**
     * @return int
     */
    public function getEnCategoryId(): int
    {
        return $this->enCategoryId;
    }

    /**
     * @param int $enCategoryId
     */
    public function setEnCategoryId(int $enCategoryId)
    {
        $this->enCategoryId = $enCategoryId;
    }

    /**
     * @return string
     */
    public function getEnCategoryName(): string
    {
        return $this->enCategoryName;
    }

    /**
     * @param string $enCategoryName
     */
    public function setEnCategoryName(string $enCategoryName)
    {
        $this->enCategoryName = $enCategoryName;
    }

    /**
     * @return int
     */
    public function getVnCategoryId(): int
    {
        return $this->vnCategoryId;
    }

    /**
     * @param int $vnCategoryId
     */
    public function setVnCategoryId(int $vnCategoryId)
    {
        $this->vnCategoryId = $vnCategoryId;
    }

    /**
     * @return string
     */
    public function getVnCategoryName(): string
    {
        return $this->vnCategoryName;
    }

    /**
     * @param string $vnCategoryName
     */
    public function setVnCategoryName(string $vnCategoryName)
    {
        $this->vnCategoryName = $vnCategoryName;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getCategoryType(): string
    {
        return $this->categoryType;
    }

    /**
     * @param string $categoryType
     */
    public function setCategoryType(string $categoryType)
    {
        $this->categoryType = $categoryType;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function addToItems(string $tag, BilingualMenuItem $item)
    {
        $this->items[$tag] = $item;
    }
}