<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 23:11
 */

namespace Ui\ApiBundle\Tests\Controller;


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

        $fs = new Filesystem();
        $fs->copy(
            __DIR__ . '/../Fixtures/time_slots.yml',
            $this->client->getContainer()->get('kernel')->getCacheDir() . '/time_slots.yml',
            true
        );
    }

    private function createTimeSlot(Client $client)
    {
        $client->request('POST', '/api/timeslots.json', array(
                'track_time' => array(
                    'startedAt' => '2015-01-14 10:00',
                    'stoppedAt' => '2015-01-14 11:00',
                )
            )
        );
    }

    public function testAll()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/api/timeslots.json');
        $response = $client->getResponse();
        $content = json_decode($response->getContent());

        $this->assertJsonResponse($response);
        $this->assertTrue(isset($content->timeSlots));
        $this->assertTrue(is_array($content->timeSlots));
        $this->assertAttributeCount(2, 'timeSlots', $content);
    }

    public function testPost()
    {
        $client   = static::createClient();

        $crawler  = $client->request('POST', '/api/timeslots.json', array());
        $response = $client->getResponse();
        $this->assertJsonResponse($response, 400);

        $this->createTimeSlot($client);
        $response = $client->getResponse();
        $this->assertJsonResponse($response, 201);

        $client->request('GET', '/api/timeslots.json');
        $response = $client->getResponse();
        $content = json_decode($response->getContent());
        $this->assertAttributeCount(3, 'timeSlots', $content);
    }

    public function testNew()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/api/timeslots/new.json');
        $response = $client->getResponse();

        $this->assertJsonResponse($response);
        $this->assertEquals('{"children":{"startedAt":[],"stoppedAt":[]}}', $response->getContent());
    }

    public function testDelete()
    {
        $client   = static::createClient();
        $crawler  = $client->request('DELETE', '/api/timeslots/62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23.json');
        $response = $client->getResponse();

        $this->assertEquals($response->getStatusCode(), 204);
        $client->request('GET', '/api/timeslots.json');
        $response = $client->getResponse();
        $content = json_decode($response->getContent());
        $this->assertAttributeCount(1, 'timeSlots', $content);
    }
} 