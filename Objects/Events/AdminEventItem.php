<?php

class AdminEventItem
{

    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var int
     */
    public $position;

    /**
     * @var ?int
     */
    public $itemId;

    /**
     * @var ?DateTime
     */
    public $createdAt;

    /**
     * @var ?DateTime
     */
    public $editedAt;

    /**
     * @var ?int
     */
    public $enId;

    /**
     * @var string
     */
    public $enTitle;

    /**
     * @var ?string
     */
    public $enDescription;

    /**
     * @var ?DateTime
     */
    public $enCreatedAt;

    /**
     * @var ?DateTime
     */
    public $enEditedAt;

    /**
     * @var ?int
     */
    public $vnId;

    /**
     * @var string
     */
    public $vnTitle;

    /**
     * @var ?string
     */
    public $vnDescription;

    /**
     * @var ?DateTime
     */
    public $vnCreatedAt;

    /**
     * @var ?DateTime
     */
    public $vnEditedAt;

    /**
     * @var DateTime
     */
    public $start;

    /**
     * @var DateTime
     */
    public $end;

    /**
     * @var bool
     */
    public $usesStartTime;

    /**
     * @var bool
     */
    public $usesEndTime;

    /**
     * @var bool
     */
    public $usesEndDate;

    /**
     * @va bool
     */
    public $valid;

    /**
     * @var bool
     */
    public $active;


    public function __construct(int $categoryId, int $position, ?int $itemId, ?DateTime $createdAt,
                                ?DateTime $editedAt, ?int $enId, string $enTitle, ?string $enDescription,
                                ?DateTime $enCreatedAt, ?DateTime $enEditedAt, ?int $vnId,
                                string $vnTitle, ?string $vnDescription, ?DateTime $vnCreatedAt,
                                ?DateTime $vnEditedAt, DateTime $start, DateTime $end,
                                bool $usesStartTime, bool $usesEndTime, bool $usesEndDate, bool $active)
    {
        $this->setCategoryId($categoryId);
        $this->setPosition($position);
        $this->setItemId($itemId);
        $this->setCreatedAt($createdAt);
        $this->setEditedAt($editedAt);
        $this->setActive($active);

        $this->setEnId($enId);
        $this->setEnTitle($enTitle);
        $this->setEnDescription($enDescription);
        $this->setEnCreatedAt($enCreatedAt);
        $this->setEnEditedAt($enEditedAt);

        $this->setVnId($vnId);
        $this->setVnTitle($vnTitle);
        $this->setVnDescription($vnDescription);
        $this->setVnCreatedAt($vnCreatedAt);
        $this->setVnEditedAt($vnEditedAt);

        $this->setStart($start);
        $this->setEnd($end);

        $this->setUsesStartTime($usesStartTime);
        $this->setUsesEndTime($usesEndTime);
        $this->setUsesEndDate($usesEndDate);

        $this->setValid();
    }

    /**
     * @return int
     */
    public function getCategoryId() : int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int
     */
    public function getPosition() : int
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

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param mixed $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * @param mixed $editedAt
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;
    }

    /**
     * @return mixed
     */
    public function getEnId()
    {
        return $this->enId;
    }

    /**
     * @param mixed $enId
     */
    public function setEnId($enId)
    {
        $this->enId = $enId;
    }

    /**
     * @return string
     */
    public function getEnTitle() : string
    {
        return $this->enTitle;
    }

    /**
     * @param string $enTitle
     */
    public function setEnTitle(string $enTitle)
    {
        $this->enTitle = $enTitle;
    }

    /**
     * @return mixed
     */
    public function getEnDescription()
    {
        return $this->enDescription;
    }

    /**
     * @param mixed $enDescription
     */
    public function setEnDescription($enDescription)
    {
        $this->enDescription = $enDescription;
    }

    /**
     * @return mixed
     */
    public function getEnCreatedAt()
    {
        return $this->enCreatedAt;
    }

    /**
     * @param mixed $enCreatedAt
     */
    public function setEnCreatedAt($enCreatedAt)
    {
        $this->enCreatedAt = $enCreatedAt;
    }

    /**
     * @return mixed
     */
    public function getEnEditedAt()
    {
        return $this->enEditedAt;
    }

    /**
     * @param mixed $enEditedAt
     */
    public function setEnEditedAt($enEditedAt)
    {
        $this->enEditedAt = $enEditedAt;
    }

    /**
     * @return mixed
     */
    public function getVnId()
    {
        return $this->vnId;
    }

    /**
     * @param mixed $vnId
     */
    public function setVnId($vnId)
    {
        $this->vnId = $vnId;
    }

    /**
     * @return string
     */
    public function getVnTitle() : string
    {
        return $this->vnTitle;
    }

    /**
     * @param string $vnTitle
     */
    public function setVnTitle(string $vnTitle)
    {
        $this->vnTitle = $vnTitle;
    }

    /**
     * @return mixed
     */
    public function getVnDescription()
    {
        return $this->vnDescription;
    }

    /**
     * @param mixed $vnDescription
     */
    public function setVnDescription($vnDescription)
    {
        $this->vnDescription = $vnDescription;
    }

    /**
     * @return mixed
     */
    public function getVnCreatedAt()
    {
        return $this->vnCreatedAt;
    }

    /**
     * @param mixed $vnCreatedAt
     */
    public function setVnCreatedAt($vnCreatedAt)
    {
        $this->vnCreatedAt = $vnCreatedAt;
    }

    /**
     * @return mixed
     */
    public function getVnEditedAt()
    {
        return $this->vnEditedAt;
    }

    /**
     * @param mixed $vnEditedAt
     */
    public function setVnEditedAt($vnEditedAt)
    {
        $this->vnEditedAt = $vnEditedAt;
    }

    /**
     * @return DateTime
     */
    public function getStart() : DateTime
    {
        return $this->start;
    }

    /**
     * @param DateTime $start
     */
    public function setStart(DateTime $start)
    {
        $this->start = $start;
    }

    /**
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param DateTime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return bool
     */
    public function isUsesStartTime() : bool
    {
        return $this->usesStartTime;
    }

    /**
     * @param bool $usesStartTime
     */
    public function setUsesStartTime(bool $usesStartTime)
    {
        $this->usesStartTime = $usesStartTime;
    }

    /**
     * @return bool
     */
    public function isUsesEndTime() : bool
    {
        return $this->usesEndTime;
    }

    /**
     * @param bool $usesEndTime
     */
    public function setUsesEndTime(bool $usesEndTime)
    {
        $this->usesEndTime = $usesEndTime;
    }

    /**
     * @return bool
     */
    public function isUsesEndDate() : bool
    {
        return $this->usesEndDate;
    }

    /**
     * @param bool $usesEndDate
     */
    public function setUsesEndDate(bool $usesEndDate)
    {
        $this->usesEndDate = $usesEndDate;
    }

    /**
     * @return mixed
     */
    public function getValid()
    {
        return $this->valid;
    }

    public function setValid()
    {
        if (isset($this->start, $this->end, $this->usesEndTime, $this->usesEndDate, $this->usesStartTime, $this->end)) {
            if ($this->usesEndDate === true) {
                $start = $this->start->format('Y-m-d');
                $end = $this->end->format('Y-m-d');
                if ($start > $end) {
                    $this->valid = false;
                } else {
                    if ($this->usesStartTime === true && $this->usesEndTime === true) {
                        $startTime = $this->start->format('H:i:s');
                        $endTime = $this->end->format('H:i:s');
                        if ($start === $end) {
                            if ($startTime > $endTime) {
                                $this->valid = false;
                            } else {
                                $this->valid = true;
                            }
                        } else {
                            $this->valid = true;
                        }
                    } else {
                        $this->valid = true;
                    }
                }
            } else {
                $this->valid = true;
            }
        } else {
            $this->valid = false;
        }
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active)
    {
        $this->active = $active;
    }

}
