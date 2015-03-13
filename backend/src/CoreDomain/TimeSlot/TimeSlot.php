<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 7:46
 */

namespace CoreDomain\TimeSlot;


class TimeSlot
{
    private $id;

    private $description;

    private $startTime;

    private $endTime;

    private function __construct(TimeSlotId $id, $description, \DateTime $startTime, \DateTime $endTime)
    {
        $this->id        = $id;
        $this->startTime = $startTime;
        $this->endTime  = $endTime;
        $this->description  = $description;
    }

    public static function track(TimeSlotId $id, $description, \DateTime $startTime, \DateTime $endTime)
    {
        return new self($id, $description, $startTime, $endTime);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }
} 