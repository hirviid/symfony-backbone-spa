<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 27/12/2014
 * Time: 11:24
 */

namespace ApiBundle\Controller;

use CoreDomain\TimeSlot\TimeSlot;
use CoreDomain\TimeSlot\TimeSlotId;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repository =  $this->get('time_slot_repository');
        $repository->add(
            new TimeSlot(new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23'), new \DateTime('2015-01-01 09:00'), new \DateTime('2015-01-01 10:00'))
        );
        $repository->add(
            new TimeSlot(new TimeSlotId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D44'), new \DateTime('2015-01-01 10:00'), new \DateTime('2015-01-01 10:45'))
        );
        return $this->render('default/index.html.twig');
    }
} 