<?php

class BilingualMenuItem
{
    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var ?string
     */
    public $enDescription;

    /**
     * @var ?int
     */
    public $enId;

    /**
     * @var string
     */
    public $enTitle;

    /**
     * @var ?int
     */
    public $itemId;

    /**
     * @var int
     */
    public $position;

    /**
     * @var string
     */
    public $price;

    /**
     * @var ?string
     */
    public $vnDescription;

    /**
     * @var ?int
     */
    public $vnId;

    /**
     * @var string
     */
    public $vnTitle;

    public function __construct($price, $position, $enTitle, $vnTitle,
                         $enDescription = null, $vnDescription = null,
                         $enId = null, $vnId = null, $itemId = null)
    {
        $this->setPrice($price);
        $this->setPosition($position);
        $this->setEnTitle($enTitle);
        $this->setEnDescription($enDescription);
        $this->setVnTitle($vnTitle);
        $this->setVnDescription($vnDescription);
        $this->setEnId($enId);
        $this->setVnId($vnId);
        $this->setItemId($itemId);
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price)
    {
        $this->price = $price;
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
    public function getEnTitle(): string
    {
        return $this->enTitle;
    }

    /**
     * @param string $enTitle
     */
    public function setEnTitle(string $enTitle)
    {
        $this->enTitle = $enTitle;
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
    public function getVnTitle(): string
    {
        return $this->vnTitle;
    }

    /**
     * @param string $vnTitle
     */
    public function setVnTitle(string $vnTitle)
    {
        $this->vnTitle = $vnTitle;
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
}