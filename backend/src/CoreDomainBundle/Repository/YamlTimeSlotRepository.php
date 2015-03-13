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
use Doctrine\Common\Cache\CacheProvider;
use Predis\Client;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Yaml\Yaml;

class YamlTimeSlotRepository implements TimeSlotRepository
{
    private $filename;
    private $cacheDriver;
    private $stopwatch;

    public function __construct($filename, Client $cacheDriver = null, Stopwatch $stopwatch = null)
    {
        $this->filename = $filename;

        $fs = new Filesystem();
        $fs->touch($this->filename);

        $this->cacheDriver = $cacheDriver;
        $this->stopwatch = $stopwatch;
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
        if (null !== $this->stopwatch) {
            $this->stopwatch->start('my_webservice', 'request');
        }

        $rows = $this->getRowsFromCache();

        $timeSlots = array();
        foreach ($rows as $row) {
            $timeSlots[] = TimeSlot::Track(
                new TimeSlotId($row['id']),
                $row['description'],
                new \DateTime($row['start_time']),
                new \DateTime($row['end_time'])
            );
        }

        if (null !== $this->stopwatch) {
            $this->stopwatch->stop('my_webservice');
        }

        return $timeSlots;
    }

    /**
     * {@inheritDoc}
     */
    public function add(TimeSlot $timeSlot)
    {
        $this->invalidateCache();

        $rows = array();
        foreach ($this->getRows() as $row) {
            if ($timeSlot->getId()->isEqualTo(new TimeSlotId($row['id']))) {
                continue;
            }

            $rows[] = $row;
        }

        $rows[] = array(
            'id'         => $timeSlot->getId()->getValue(),
            'description' => $timeSlot->getDescription(),
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
        $this->invalidateCache();

        $rows = array();
        foreach ($this->getRows() as $row) {
            if ($timeSlot->getId()->isEqualTo(new TimeSlotId($row['id']))) {
                continue;
            }

            $rows[] = $row;
        }

        file_put_contents($this->filename, Yaml::dump($rows));
    }

    private function invalidateCache()
    {
        if (null === $this->cacheDriver) {
            return;
        }

        $this->cacheDriver->set('timeSlots', null);
    }

    private function getRowsFromCache()
    {
        if (null === $this->cacheDriver) {
            return $this->getRows();
        }

        $response = $this->cacheDriver->get('timeSlots');

        if (null !== $response && '' !== $response) {
            return unserialize($response);
        }

        $rows = $this->getRows();
        $this->cacheDriver->set('timeSlots', serialize($rows));

        return $rows;
    }

    private function getRows()
    {
        return Yaml::parse($this->filename) ?: array();
    }
}