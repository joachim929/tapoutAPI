<?php

class ImageList
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $imgUrl;

    /**
     * @var DateTime
     */
    public $createdAt;

    function __construct($id, $imgUrl, $createdAt)
    {
        $this->setId($id);
        $this->setImgUrl($imgUrl);
        $this->setCreatedAt($createdAt);
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

    // @todo: Figure out best way to use image height/width or ratio
    //public $ratio;
}