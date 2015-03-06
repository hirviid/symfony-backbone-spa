<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 10/01/2015
 * Time: 9:27
 */

namespace Ui\SharedBundle\Form\Handler;


use CoreDomain\TimeSlot\TimeSlot;
use CoreDomain\TimeSlot\TimeSlotId;
use CoreDomain\TimeSlot\TimeSlotRepository;
use Hirviid\DDD\Commands\CommandHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Ui\SharedBundle\Request\TrackTimeRequest;

class TrackTimeFormHandler
{
    private $commandHandler;

    public function __construct(CommandHandlerInterface $commandHandler)
    {
        $this->commandHandler = $commandHandler;
    }

    public function handle(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        $trackTimeRequest = new TrackTimeRequest($request->request->get('track_time'));

        $this->commandHandler->handle($trackTimeRequest->getData());

        return true;
    }

    public function handleForm(FormInterface $form, Request $request)
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