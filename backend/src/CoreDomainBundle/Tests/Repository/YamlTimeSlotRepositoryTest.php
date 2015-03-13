<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 21:48
 */

namespace CoreDomainBundle\Tests\Repository;


use CoreDomain\TimeSlot\TimeSlot;
use CoreDomain\TimeSlot\TimeSlotId;
use CoreDomainBundle\Repository\YamlTimeSlotRepository;
use CoreDomainBundle\Tests\TestCase;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * Unit Test Example
 *
 * Class YamlTimeSlotRepositoryTest
 * @package CoreDomainBundle\Tests\Repository
 */
class YamlTimeSlotRepositoryTest extends TestCase
{

    /** @var vfsStreamDirectory  */
    private $cacheDir;

    /**
     * @var YamlTimeSlotRepository
     */
    private $repository;

    protected function setUp()
    {
        $this->cacheDir   = vfsStream::setup('cache');
        $this->repository = new YamlTimeSlotRepository(vfsStream::url('cache/time_slots.yml'));
    }

    protected function addTimeSlots()
    {
        $this->repository->add(
            TimeSlot::track(new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23'), 'task1', new \DateTime('2015-01-01 09:00'), new \DateTime('2015-01-01 10:00'))
        );
        $this->repository->add(
            TimeSlot::track(new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D44'), 'task2', new \DateTime('2015-01-01 10:00'), new \DateTime('2015-01-01 10:45'))
        );
    }

    public function testFind()
    {
        $this->addTimeSlots();

        /** @var TimeSlot $timeSlot */
        $timeSlot = $this->repository->find(
            new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23')
        );

        $this->assertNotNull($timeSlot);
        $this->assertInstanceOf('CoreDomain\TimeSlot\TimeSlot', $timeSlot);
        $this->assertEquals(new \DateTime('2015-01-01 09:00'), $timeSlot->getStartTime());
    }

    public function testFindReturnsNullIfNotFound()
    {
        $timeSlot = $this->repository->find(
            new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23')
        );

        $this->assertNull($timeSlot);
    }

    public function testAdd()
    {
        /*$this->addTimeSlots();
        $expected = <<<YAML
-
    id: 62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23
    start_time: '2015-01-01 09:00:00'
    end_time: '2015-01-01 10:00:00'
-
    id: 62A0CEB4-0403-4AA6-A6CD-1EE808AD4D44
    start_time: '2015-01-01 10:00:00'
    end_time: '2015-01-01 10:45:00'

YAML;

        $this->assertEquals(
            $expected,
            $this->cacheDir->getChild('time_slots.yml')->getContent()
        );*/
    }

    public function testRemove()
    {
        $this->addTimeSlots();
        /** @var TimeSlot $timeSlot */
        $timeSlot = $this->repository->find(
            new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23')
        );
        $this->repository->remove($timeSlot);

        $timeSlot = $this->repository->find(
            new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23')
        );
        $timeSlot2 = $this->repository->find(
            new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D44')
        );

        $this->assertNull($timeSlot);
        $this->assertNotNull($timeSlot2);
        $this->assertInstanceOf('CoreDomain\TimeSlot\TimeSlot', $timeSlot2);
    }

    public function testFindAll()
    {
        $this->addTimeSlots();
        $timeSlots = $this->repository->findAll();
        $this->assertEquals(
            $timeSlots[0],
            TimeSlot::track(new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23'), 'task1', new \DateTime('2015-01-01 09:00'), new \DateTime('2015-01-01 10:00'))
        );
        $this->assertEquals(
            $timeSlots[1],
            TimeSlot::track(new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D44'), 'task2', new \DateTime('2015-01-01 10:00'), new \DateTime('2015-01-01 10:45'))
        );
    }
}