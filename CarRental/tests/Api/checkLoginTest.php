<?php

namespace Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class checkLoginTest extends ApiTestCase
{
    /**
     * @throws TransportExceptionInterface
     */
    public function testGetToken()
    {
        $client = static::createClient();
        $this->getLoginToken($client);
        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * @throws TransportExceptionInterface
     */
    static public function getLoginToken($client): ResponseInterface
    {
        return $client->request('POST', '/api/login_check', [
            'json' => [
                'username' => 'RubyeeRu',
                'password' => 'test',
            ],
        ]);
    }
}