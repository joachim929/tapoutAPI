<?php

class EventCategory
{
    /**
     * @var int
     */
    var $id;

    /**
     * @var string
     */
    var $name;

    /**
     * @var string
     */
    var $type;

    /**
     * @var string
     */
    var $language;

    /**
     * @var string
     */
    var $tag;

    /**
     * @var DateTime
     */
    var $createdAt;

    /**
     * @var DateTime
     */
    var $editedAt;

    /**
     * @var int
     */
    var $pagePosition;

    /**
     * @var array
     */
    var $categoryItems;

    function __construct($name, $type, $language, $tag, $pagePosition,
                         $id = null, $createdAt = null, $editedAt = null)
    {
        $this->setName($name);
        $this->setType($type);
        $this->setLanguage($language);
        $this->setTag($tag);
        $this->setPagePosition($pagePosition);

        if($id !== null) {
            $this->setId($id);
        }

        if($createdAt !== null) {
            $this->setCreatedAt($createdAt);
        }

        if($editedAt !== null) {
            $this->setEditedAt($editedAt);
        }

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
    }

    /**
     * @return int
     */
    public function getPagePosition(): int
    {
        return $this->pagePosition;
    }

    /**
     * @param int $pagePosition
     */
    public function setPagePosition(int $pagePosition)
    {
        $this->pagePosition = $pagePosition;
    }

    /**
     * @return array
     */
    public function getCategoryItems(): array
    {
        return $this->categoryItems;
    }

    /**
     * @param array $categoryItems
     */
    public function setCategoryItems(array $categoryItems)
    {
        $this->categoryItems = $categoryItems;
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

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getEditedAt(): DateTime
    {
        return $this->editedAt;
    }

    /**
     * @param DateTime $editedAt
     */
    public function setEditedAt(DateTime $editedAt)
    {
        $this->editedAt = $editedAt;
    }
}