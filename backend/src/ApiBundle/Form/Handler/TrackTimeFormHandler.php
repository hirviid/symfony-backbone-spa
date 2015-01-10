<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 10/01/2015
 * Time: 9:27
 */

namespace ApiBundle\Form\Handler;


use CoreDomain\TimeSlot\TimeSlot;
use CoreDomain\TimeSlot\TimeSlotId;
use CoreDomain\TimeSlot\TimeSlotRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class TrackTimeFormHandler
{
    private $repository;

    public function __construct(TimeSlotRepository $repository)
    {
        $this->repository = $repository;
    }

    public function Handle(FormInterface $form, Request $request)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->submit($request);

        if (!$form->isValid()) {
            return false;
        }

        $trackTimeCommand = $form->getData();
        $timeSlot = TimeSlot::track(
            new TimeSlotId(trim(self::GUID(), '{}')),
            new \DateTime($trackTimeCommand->startedAt),
            new \DateTime($trackTimeCommand->stoppedAt)
        );
        $this->repository->add($timeSlot);
        return true;
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