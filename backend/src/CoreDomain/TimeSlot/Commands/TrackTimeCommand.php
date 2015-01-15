<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 23:58
 */

namespace CoreDomain\TimeSlot\Commands;

use Hirviid\DDD\Commands\CommandInterface;

class TrackTimeCommand implements CommandInterface
{
    /**
     * @var \DateTime
     */
    public $startedAt;

    /**
     * @var \DateTime
     */
    public $stoppedAt;
} 