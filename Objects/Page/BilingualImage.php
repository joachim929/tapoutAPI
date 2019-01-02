<?php

class BilingualImage
{
    /**
     * @var int
     */
    public $pageId;

    /**
     * @var int
     */
    public $pagePosition;

    /**
     * @var string
     */
    public $imgUrl;

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
     * @var int
     */
    public $enImageId;

    /**
     * @var string|null
     */
    public $enCaption;

    /**
     * @var string
     */
    public $enAlt;

    /**
     * @var int
     */
    public $vnImageId;

    /**
     * @var string|null
     */
    public $vnCaption;

    /**
     * @var string
     */
    public $vnAlt;

    /**
     * @var ?DateTime
     */
    public $createdAt;

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
     * @return string
     */
    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    /**
     * @param string $imgUrl
     */
    public function setImgUrl(string $imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width)
    {
        $this->width = $width;
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
    public function getEnImageId(): int
    {
        return $this->enImageId;
    }

    /**
     * @param int $enImageId
     */
    public function setEnImageId(int $enImageId)
    {
        $this->enImageId = $enImageId;
    }

    /**
     * @return null|string
     */
    public function getEnCaption()
    {
        return $this->enCaption;
    }

    /**
     * @param null|string $enCaption
     */
    public function setEnCaption($enCaption)
    {
        $this->enCaption = $enCaption;
    }

    /**
     * @return string
     */
    public function getEnAlt(): string
    {
        return $this->enAlt;
    }

    /**
     * @param string $enAlt
     */
    public function setEnAlt(string $enAlt)
    {
        $this->enAlt = $enAlt;
    }

    /**
     * @return int
     */
    public function getVnImageId(): int
    {
        return $this->vnImageId;
    }

    /**
     * @param int $vnImageId
     */
    public function setVnImageId(int $vnImageId)
    {
        $this->vnImageId = $vnImageId;
    }

    /**
     * @return null|string
     */
    public function getVnCaption()
    {
        return $this->vnCaption;
    }

    /**
     * @param null|string $vnCaption
     */
    public function setVnCaption($vnCaption)
    {
        $this->vnCaption = $vnCaption;
    }

    /**
     * @return string
     */
    public function getVnAlt(): string
    {
        return $this->vnAlt;
    }

    /**
     * @param string $vnAlt
     */
    public function setVnAlt(string $vnAlt)
    {
        $this->vnAlt = $vnAlt;
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
}