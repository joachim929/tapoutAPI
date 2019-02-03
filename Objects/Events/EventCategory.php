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
     * @var int
     */
    public $position;

    /**
     * @var array
     */
    public $items;

    public function __construct ($name, $type, $position,
                                 ?int $id)
    {

        $this->setName($name);
        $this->setType($type);
        $this->setPosition($position);
        $this->setId($id);
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
     * @return array
     */
    public function getItems () : array
    {

        return $this->items;
    }

    /**
     * @param array $item
     */
    public function setItems (array $item)
    {

        $this->items = $item;
    }

    /**
     * @param EventItem $item
     */
    public function addItem(EventItem $item)
    {
        $now = new DateTime('+2 days');
        if ($this->type === 'unique') {
            if ($item->getStart() > $now && $item->isValid()) {
                $this->items[] = $item;
            }
        } elseif ($item->isValid()) {
            $this->items[] = $item;
        }
    }

}