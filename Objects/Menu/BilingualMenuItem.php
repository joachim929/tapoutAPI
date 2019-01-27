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
     * @var ?string
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
     * @var ?string
     */
    public $vnTitle;

    /**
     * @var ?DateTime
     */
    public $createdAt;

    /**
     * @var ?DateTime
     */
    public $editedAt;

    public function __construct (string $price, int $position, ?string $enTitle, ?string $vnTitle,
                                 ?string $enDescription, ?string $vnDescription,
                                 ?int $enId, ?int $vnId, ?int $itemId)
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
     * @return int
     */
    public function getPosition() : int
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
    public function getPrice() : string
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