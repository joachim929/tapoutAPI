<?php

class PageImage
{

    /**
     * @var int
     */
    public $pageId;

    /**
     * @var string
     */
    public $imgUrl;

    /**
     * @var int
     */
    public $pagePosition;

    /**
     * @var int
     */
    public $height;

    /**
     * @var int
     */
    public $width;

    /**
     * @var string
     */
    public $tag;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string|null
     */
    public $caption;

    /**
     * @var string|null
     */
    public $alt;

    /**
     * @var dateTime|null
     */
    public $createdAt;

    /**
     * @var int|null
     */
    public $id;

    public function __construct (
        $pageId, $imageUrl, $pagePosition, $height, $width, $tag, $language,
        $caption = null, $alt = null, $createdAt = null, $id = null
    )
    {

        $this->setPageId($pageId);
        $this->setImgUrl($imageUrl);
        $this->setPagePosition($pagePosition);
        $this->setHeight($height);
        $this->setWidth($width);
        $this->setTag($tag);
        $this->setLanguage($language);
        $this->setCaption($caption);
        $this->setAlt($alt);
        $this->setCreatedAt($createdAt);
        $this->setId($id);
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
    public function getImgUrl () : string
    {

        return $this->imgUrl;
    }

    /**
     * @param string $imgUrl
     */
    public function setImgUrl (string $imgUrl)
    {

        $this->imgUrl = $imgUrl;
    }

    /**
     * @return dateTime|null
     */
    public function getCreatedAt ()
    {

        return $this->createdAt;
    }

    /**
     * @param dateTime|null $createdAt
     */
    public function setCreatedAt ($createdAt)
    {

        $this->createdAt = $createdAt;
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
     * @return null|string
     */
    public function getCaption ()
    {

        return $this->caption;
    }

    /**
     * @param null|string $caption
     */
    public function setCaption ($caption)
    {

        $this->caption = $caption;
    }

    /**
     * @return null|string
     */
    public function getAlt ()
    {

        return $this->alt;
    }

    /**
     * @param null|string $alt
     */
    public function setAlt ($alt)
    {

        $this->alt = $alt;
    }

    /**
     * @return int
     */
    public function getHeight () : int
    {

        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight (int $height)
    {

        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth () : int
    {

        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth (int $width)
    {

        $this->width = $width;
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

}