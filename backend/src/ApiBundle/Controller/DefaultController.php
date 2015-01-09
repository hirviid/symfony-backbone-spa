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
use Symfony\Component\Filesystem\Filesystem;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /*(new Filesystem())->copy(
            __DIR__ . '/../Tests/Fixtures/time_slots.yml',
            $this->get('kernel')->getCacheDir() . '/time_slots.yml',
            true
        );*/
        return $this->render('default/index.html.twig');
    }
} 