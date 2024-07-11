<?php

namespace Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetUserReservationTest extends ApiTestCase
{
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Get the entity manager and repository
        $this->userRepository = self::getContainer()->get(UserRepository::class);
    }
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    function testGetUserReservation()
    {
        $client = static::createClient();
        $loginResponseContent = checkLoginTest::getLoginToken($client)->getContent();
        $token = isset(json_decode($loginResponseContent, true)['token']) ?
            json_decode($loginResponseContent, true)['token']
            : null;

        $user = $this->userRepository->findOneBy(['email' => 'Rubye.Ruecker@gmail.com']);
        $response = $client->request('GET', sprintf('/api/users/%s/reservations',$user->getId()), [
            'headers' => [
                'Authorization' => 'Bearer '. $token
            ],
        ]);
        $this->assertResponseStatusCodeSame(200);
        $this->assertGreaterThan(0, json_decode($response->getContent(), true)['hydra:totalItems']);
    }
}