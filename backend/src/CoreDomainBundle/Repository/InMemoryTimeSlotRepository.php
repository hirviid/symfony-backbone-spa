<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 7:54
 */

namespace CoreDomainBundle\Repository;


use CoreDomain\TimeSlot\TimeSlot;
use CoreDomain\TimeSlot\TimeSlotId;
use CoreDomain\TimeSlot\TimeSlotRepository;

class InMemoryTimeSlotRepository implements TimeSlotRepository
{
    private $timeSlots;

    public function __construct()
    {
        $this->timeSlots[] = TimeSlot::track(
            new TimeSlotId('8CE05088-ED1F-43E9-A415-3B3792655A9B'), new \DateTime('2015-01-01 09:00'), new \DateTime('2015-01-01 10:00')
        );
        $this->timeSlots[] = TimeSlot::track(
            new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23'),new \DateTime('2015-01-01 10:00'), new \DateTime('2015-01-01 10:45')
        );
    }

    public function find(TimeSlotId $timeSlotId)
    {
    }

    public function findAll()
    {
        return $this->timeSlots;
    }

    public function add(TimeSlot $timeSlot)
    {
    }

    public function remove(TimeSlot $timeSlot)
    {
    }
} 