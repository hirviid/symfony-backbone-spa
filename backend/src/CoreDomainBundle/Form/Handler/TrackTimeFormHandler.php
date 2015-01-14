<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 10/01/2015
 * Time: 9:27
 */

namespace CoreDomainBundle\Form\Handler;


use CoreDomain\TimeSlot\TimeSlot;
use CoreDomain\TimeSlot\TimeSlotId;
use CoreDomain\TimeSlot\TimeSlotRepository;
use DDD\Commands\CommandHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class TrackTimeFormHandler
{
    private $commandHandler;

    public function __construct(CommandHandlerInterface $commandHandler)
    {
        $this->commandHandler = $commandHandler;
    }

    public function handle(FormInterface $form, Request $request)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->submit($request);

        if (!$form->isValid()) {
            return false;
        }

        $trackTimeCommand = $form->getData();
        $this->commandHandler->handle($trackTimeCommand);

        return true;
    }

}