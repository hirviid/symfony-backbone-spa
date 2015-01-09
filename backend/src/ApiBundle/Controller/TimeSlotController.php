<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 8:13
 */

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TimeSlotController extends Controller
{
    /**
     * @Rest\View
     */
    public function allAction()
    {
        $timeSlots = $this->get('time_slot_repository')->findAll();

        return array('timeSlots' => $timeSlots);
    }
}