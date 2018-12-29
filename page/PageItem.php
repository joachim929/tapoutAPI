<?php

class pageItem
{
    /**
     * @var int | null
     */
    var $id;

    /**
     * @var int
     */
    var $pageId;

    /**
     * @var string
     */
    var $heading;

    /**
     * @var string
     */
    var $content;

    /**
     * @var dateTime | null
     */
    var $createdAt;

    /**
     * @var dateTime | null
     */
    var $editedAt;

    /**
     * @var string
     */
    var $language;

    /**
     * @var string
     */
    var $tag;

    /**
     * @var int
     */
    var $pagePosition;

    function __construct($pageId, $heading, $content, $language, $tag, $pagePosition, $id = null, $createdAt = null, $editedAt = null)
    {
        $this->setPageId($pageId);
        $this->setHeading($heading);
        $this->setContent($content);
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
     * @return int
     */
    public function getPageId(): int
    {
        return $this->pageId;
    }

    /**
     * @param int $pageId
     */
    public function setPageId(int $pageId)
    {
        $this->pageId = $pageId;
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     */
    public function setHeading(string $heading)
    {
        $this->heading = $heading;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return dateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param dateTime|null $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return dateTime|null
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * @param dateTime|null $editedAt
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;
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
}