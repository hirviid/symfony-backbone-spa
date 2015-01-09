<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 7:48
 */

namespace CoreDomain\TimeSlot;


class TimeSlotId 
{
    private $value;

    public function __construct($value)
    {
        $this->value = (string) $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function isEqualTo(TimeSlotId $timeSlotId)
    {
        return $this->getValue() === $timeSlotId->getValue();
    }
} 