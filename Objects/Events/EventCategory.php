<?php

class EventCategory
{

    /**
     * @var ?int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $language;

    /**
     * @var ?DateTime
     */
    public $createdAt;

    /**
     * @var ?DateTime
     */
    public $editedAt;

    /**
     * @var int
     */
    public $pagePosition;

    /**
     * @var array
     */
    public $item;

    public function __construct ($name, $type, $language, $pagePosition,
                                 $id = null, $createdAt = null, $editedAt = null)
    {

        $this->setName($name);
        $this->setType($type);
        $this->setLanguage($language);
        $this->setPagePosition($pagePosition);
        $this->setId($id);
        $this->setCreatedAt($createdAt);
        $this->setEditedAt($editedAt);
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
     * @return string
     */
    public function getName () : string
    {

        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName (string $name)
    {

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType () : string
    {

        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType (string $type)
    {

        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getLanguage () : string
    {

        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage (string $language)
    {

        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt ()
    {

        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt ($createdAt)
    {

        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getEditedAt ()
    {

        return $this->editedAt;
    }

    /**
     * @param mixed $editedAt
     */
    public function setEditedAt ($editedAt)
    {

        $this->editedAt = $editedAt;
    }

    /**
     * @return int
     */
    public function getPagePosition () : int
    {

        return $this->pagePosition;
    }

    /**
     * @param int $pagePosition
     */
    public function setPagePosition (int $pagePosition)
    {

        $this->pagePosition = $pagePosition;
    }

    /**
     * @return array
     */
    public function getItems () : array
    {

        return $this->item;
    }

    /**
     * @param array $item
     */
    public function setItems (array $item)
    {

        $this->item = $item;
    }

}