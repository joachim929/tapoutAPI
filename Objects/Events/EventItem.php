<?php

class EventItem
{

    /**
     * @var ?int
     */
    public $id;

    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var string
     */
    public $title;

    /**
     * @var ?string
     */
    public $description;

    /**
     * @var int
     */
    public $position;

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
     * @var bool
     */
    public $valid;

    public function __construct(int $categoryId, string $title, int $position,
                                DateTime $start, DateTime $end, ?int $id,
                                ?string $description, bool $usesStartTime,
                                bool $usesEndTime, bool $usesEndDate)
    {
        $this->setCategoryId($categoryId);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setPosition($position);
        $this->setId($id);

        $this->setUsesStartTime($usesStartTime);
        $this->setStart($start);

        $this->setUsesEndTime($usesEndTime);
        $this->setUsesEndDate($usesEndDate);
        $this->setEnd($end);

        $this->setValid();
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
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
        if ($this->usesStartTime) {
            $this->start = $start;
        } else {
            $this->start = ($start->setTime(13, 37, 13));
        }
    }

    /**
     * @return DateTime
     */
    public function getEnd() : DateTime
    {
        return $this->end;
    }

    /**
     * @param DateTime $end
     */
    public function setEnd(DateTime $end)
    {
        if (!$this->usesEndDate) {
            $end = $end->setDate(2013, 3, 7);
        }
        if (!$this->usesEndTime) {
            $end = $end->setTime(13, 37, 13);
        }
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
     * @return bool
     */
    public function isValid() : bool
    {
        return $this->valid;
    }

    public function setValid()
    {
        if (isset($this->start, $this->end, $this->usesEndTime, $this->usesEndDate, $this->usesStartTime)) {
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
}
