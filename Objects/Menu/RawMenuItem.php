<?php

class RawMenuItem
{

    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var DateTime|null
     */
    public $createdAt;

    /**
     * @var DateTime|null
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

    public function __construct ($categoryId, $price, $position, $createdAt = null, $editedAt = null, $id = null)
    {

        $this->setCategoryId($categoryId);
        $this->setCreatedAt($createdAt);
        $this->setEditedAt($editedAt);
        $this->setId($id);
        $this->setPrice($price);
        $this->setPosition($position);
    }

    /**
     * @return int|null
     */
    public function getId ()
    {

        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId ($id)
    {

        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCategoryId () : int
    {

        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId (int $categoryId)
    {

        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getPrice () : string
    {

        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice (string $price)
    {

        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getPosition () : int
    {

        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition (int $position)
    {

        $this->position = $position;
    }

    /**
     * This function increases the position by one
     */
    public function incrementPosition()
    {
        $this->position++;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt () : DateTime
    {

        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     */
    public function setCreatedAt (DateTime $createdAt)
    {

        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime|null
     */
    public function getEditedAt ()
    {

        return $this->editedAt;
    }

    /**
     * @param DateTime|null $editedAt
     */
    public function setEditedAt ($editedAt)
    {

        $this->editedAt = $editedAt;
    }

}