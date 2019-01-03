<?php

class NewBilingualMenuCategory
{
    /**
     * @var ?int
     */
    public $id;

    /**
     * @var string
     */
    public $enName;

    /**
     * @var string
     */
    public $vnName;

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

    function __construct($enName, $vnName, $type, $position, $id = null)
    {
        $this->setEnName($enName);
        $this->setVnName($vnName);
        $this->setType($type);
        $this->setPosition($position);
        $this->setId($id);
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

    public function addItem(NewBilingualMenuItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEnName(): string
    {
        return $this->enName;
    }

    /**
     * @param string $enName
     */
    public function setEnName(string $enName)
    {
        $this->enName = $enName;
    }

    /**
     * @return string
     */
    public function getVnName(): string
    {
        return $this->vnName;
    }

    /**
     * @param string $vnName
     */
    public function setVnName(string $vnName)
    {
        $this->vnName = $vnName;
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
}