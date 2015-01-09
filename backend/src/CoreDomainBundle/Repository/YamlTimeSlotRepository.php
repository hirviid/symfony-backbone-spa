<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 21:34
 */

namespace CoreDomainBundle\Repository;


use CoreDomain\TimeSlot\TimeSlot;
use CoreDomain\TimeSlot\TimeSlotId;
use CoreDomain\TimeSlot\TimeSlotRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class YamlTimeSlotRepository implements TimeSlotRepository
{
    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;

        (new Filesystem())->touch($this->filename);
    }

    /**
     * {@inheritDoc}
     */
    public function find(TimeSlotId $timeSlotId)
    {
        /** @var TimeSlot $timeSlot */
        foreach ($this->findAll() as $timeSlot) {
            if ($timeSlot->getId()->isEqualTo($timeSlotId)) {
                return $timeSlot;
            }
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        $timeSlots = array();
        foreach ($this->getRows() as $row) {
            $timeSlots[] = TimeSlot::Track(
                new TimeSlotId($row['id']),
                new \DateTime($row['start_time']),
                new \DateTime($row['end_time'])
            );
        }

        return $timeSlots;
    }

    /**
     * {@inheritDoc}
     */
    public function add(TimeSlot $timeSlot)
    {
        $rows = array();
        foreach ($this->getRows() as $row) {
            if ($timeSlot->getId()->isEqualTo(new TimeSlotId($row['id']))) {
                continue;
            }

            $rows[] = $row;
        }

        $rows[] = array(
            'id'         => $timeSlot->getId()->getValue(),
            'start_time' => $timeSlot->getStartTime()->format('Y-m-d H:i:s'),
            'end_time'  => $timeSlot->getEndTime()->format('Y-m-d H:i:s'),
        );

        file_put_contents($this->filename, Yaml::dump($rows));
    }

    /**
     * {@inheritDoc}
     */
    public function remove(TimeSlot $timeSlot)
    {
        $rows = array();
        foreach ($this->getRows() as $row) {
            if ($timeSlot->getId()->isEqualTo(new TimeSlotId($row['id']))) {
                continue;
            }

            $rows[] = $row;
        }

        file_put_contents($this->filename, Yaml::dump($rows));
    }

    private function getRows()
    {
        return Yaml::parse($this->filename) ?: array();
    }
}