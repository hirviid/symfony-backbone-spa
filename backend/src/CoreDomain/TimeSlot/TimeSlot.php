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

    private $startTime;

    private $endTime;

    private function __construct(TimeSlotId $id, \DateTime $startTime, \DateTime $endTime)
    {
        $this->id        = $id;
        $this->startTime = $startTime;
        $this->endTime  = $endTime;
    }

    public static function track(TimeSlotId $id, \DateTime $startTime, \DateTime $endTime)
    {
        return new self($id, $startTime, $endTime);
    }

    public function getId()
    {
        return $this->id;
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