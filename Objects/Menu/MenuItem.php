<?php

class MenuItem
{

    /**
     * @var ?string;
     */
    public $description;

    /**
     * @var ?int
     */
    public $id;

    /**
     * @var int
     */
    public $position;

    /**
     * @var string
     */
    public $price;

    /**
     * @var string
     */
    public $title;

    public function __construct ($description, $position, $price, $title, $id = null)
    {

        $this->setDescription($description);
        $this->setId($id);
        $this->setPosition($position);
        $this->setPrice($price);
        $this->setTitle($title);
    }

    /**
     * @return mixed
     */
    public function getDescription ()
    {

        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription ($description)
    {

        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getId ()
    {

        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId ($id)
    {

        $this->id = $id;
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
     * @return string
     */
    public function getTitle () : string
    {

        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle (string $title)
    {

        $this->title = $title;
    }

}