<?php

namespace Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetCarsTest extends ApiTestCase
{

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    function testGetCars()
    {
        $client = static::createClient();
        $loginResponseContent = checkLoginTest::getLoginToken($client)->getContent();
        $token = isset(json_decode($loginResponseContent, true)['token']) ?
            json_decode($loginResponseContent, true)['token']
            : null;

        $response = $client->request('GET', '/api/cars', [
            'headers' => [
                'Authorization' => 'Bearer '. $token
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
    }
}