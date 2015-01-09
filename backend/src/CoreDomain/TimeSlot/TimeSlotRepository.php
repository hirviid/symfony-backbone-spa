<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 7:49
 */

namespace CoreDomain\TimeSlot;


interface TimeSlotRepository
{
    public function find(TimeSlotId $timeSlotId);

    public function findAll();

    public function add(TimeSlot $timeSlot);

    public function remove(TimeSlot $timeSlot);
} 