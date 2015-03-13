<?php
/**
 * User: david.vangompel@calibrate.be
 * Date: 14/01/15
 * Time: 20:51
 */

namespace CoreDomain\TimeSlot\Commands;


use CoreDomain\TimeSlot\TimeSlot;
use CoreDomain\TimeSlot\TimeSlotId;
use CoreDomain\TimeSlot\TimeSlotRepository;
use Hirviid\DDD\Commands\CommandHandlerInterface;
use Hirviid\DDD\Commands\CommandInterface;

class TrackTimeCommandHandler implements CommandHandlerInterface
{
    private $repository;

    public function __construct(TimeSlotRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CommandInterface $command)
    {
        /** @var $command TrackTimeCommand */
        if (false === $this->supportsClass($command)) {
            return;
        }

        $timeSlot = TimeSlot::track(
            new TimeSlotId(trim(self::GUID(), '{}')),
            $command->description,
            new \DateTime($command->startedAt),
            new \DateTime($command->stoppedAt)
        );

        $this->repository->add($timeSlot);
    }

    public function supportsClass(CommandInterface $command)
    {
        return $command instanceof TrackTimeCommand;
    }

    private static function GUID()
    {
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }
} 