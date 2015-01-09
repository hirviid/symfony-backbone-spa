<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 23:11
 */

namespace ApiBundle\Tests\Controller;


use Bazinga\Bundle\RestExtraBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Functional test example
 *
 * Class TimeSlotControllerTest
 * @package ApiBundle\Tests\Controller
 */
class TimeSlotControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();

        (new Filesystem())->copy(
            __DIR__ . '/../Fixtures/time_slots.yml',
            $this->client->getContainer()->get('kernel')->getCacheDir() . '/time_slots.yml',
            true
        );
    }

    public function testAll()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/api/timeslots.json');
        $response = $client->getResponse();

        $this->assertJsonResponse($response);
    }
} 