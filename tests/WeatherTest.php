<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Weather;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherTest extends ApiTestCase
{
    public function testFetchWeather(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/weather');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals('/api/weather', $response->toArray()['@id']);
        $this->assertCount(2, $response->toArray()['hydra:member']);
    }
}