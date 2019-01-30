<?php

class RawMenuItem
{

    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var ?DateTime
     */
    public $createdAt;

    /**
     * @var ?DateTime
     */
    public $editedAt;

    /**
     * @var int|null
     */
    public $id;

    /**
     * @var string
     */
    public $price;

    /**
     * @var int
     */
    public $position;

    public function __construct ($categoryId, $price, $position, ?DateTime $createdAt, ?DateTime $editedAt, ?int $id)
    {

        $this->setCategoryId($categoryId);
        $this->setCreatedAt($createdAt);
        $this->setEditedAt($editedAt);
        $this->setId($id);
        $this->setPrice($price);
        $this->setPosition($position);
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

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

}