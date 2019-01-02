<?php

class BilingualMenuItem
{
    /**
     * @var ?int
     */
    public $enItemId;

    /**
     * @var ?string
     */
    public $enTitle;

    /**
     * @var ?string
     */
    public $enDescription;

    /**
     * @var ?int
     */
    public $vnItemId;

    /**
     * @var ?string
     */
    public $vnTitle;

    /**
     * @var ?string;
     */
    public $vnDescription;

    /**
     * @var string
     */
    public $price;

    /**
     * @var int
     */
    public $position;

    /**
     * @var string
     */
    public $tag;

    function __construct($price, $position, $tag)
    {
        $this->setPrice($price);
        $this->setPosition($position);
        $this->setTag($tag);
    }

    public function setEnglish($id, $title, $description)
    {
        $this->setEnItemId($id);
        $this->setEnTitle($title);
        $this->setEnDescription($description);
    }

    public function setVietnamese($id, $title, $description)
    {
        $this->setVnItemId($id);
        $this->setVnTitle($title);
        $this->setVnDescription($description);
    }

    /**
     * @return mixed
     */
    public function getEnItemId()
    {
        return $this->enItemId;
    }

    /**
     * @param mixed $enItemId
     */
    public function setEnItemId($enItemId)
    {
        $this->enItemId = $enItemId;
    }

    /**
     * @return mixed
     */
    public function getEnTitle()
    {
        return $this->enTitle;
    }

    /**
     * @param mixed $enTitle
     */
    public function setEnTitle($enTitle)
    {
        $this->enTitle = $enTitle;
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
    public function getVnItemId()
    {
        return $this->vnItemId;
    }

    /**
     * @param mixed $vnItemId
     */
    public function setVnItemId($vnItemId)
    {
        $this->vnItemId = $vnItemId;
    }

    /**
     * @return mixed
     */
    public function getVnTitle()
    {
        return $this->vnTitle;
    }

    /**
     * @param mixed $vnTitle
     */
    public function setVnTitle($vnTitle)
    {
        $this->vnTitle = $vnTitle;
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
}