<?php

class pageItem
{

    /**
     * @var ?int
     */
    public $id;

    /**
     * @var int
     */
    public $pageId;

    /**
     * @var string
     */
    public $heading;

    /**
     * @var string
     */
    public $content;

    /**
     * @var ?DateTime
     */
    public $createdAt;

    /**
     * @var ?DateTime
     */
    public $editedAt;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $tag;

    /**
     * @var int
     */
    public $pagePosition;

    public function __construct ($pageId, $heading, $content, $language, $tag, $pagePosition, $id = null, $createdAt = null, $editedAt = null)
    {

        $this->setPageId($pageId);
        $this->setHeading($heading);
        $this->setContent($content);
        $this->setLanguage($language);
        $this->setTag($tag);
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
     * @return int
     */
    public function getPageId () : int
    {

        return $this->pageId;
    }

    /**
     * @param int $pageId
     */
    public function setPageId (int $pageId)
    {

        $this->pageId = $pageId;
    }

    /**
     * @return string
     */
    public function getHeading () : string
    {

        return $this->heading;
    }

    /**
     * @param string $heading
     */
    public function setHeading (string $heading)
    {

        $this->heading = $heading;
    }

    /**
     * @return string
     */
    public function getContent () : string
    {

        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent (string $content)
    {

        $this->content = $content;
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
     * @return string
     */
    public function getTag () : string
    {

        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag (string $tag)
    {

        $this->tag = $tag;
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

}