<?php

namespace Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CreateReservationTest extends ApiTestCase
{
    private UserRepository $userRepository;
    private CarRepository $carRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Get the entity manager and repository
        $this->userRepository = self::getContainer()->get(UserRepository::class);
        $this->carRepository = self::getContainer()->get(CarRepository::class);
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
        $car = $this->carRepository->findOneBy(['registrationNumber' => 'GHI-3456']);
        $response = $client->request('POST','/api/reservations', [
            'headers' => [
                'Authorization' => 'Bearer '. $token
            ],
            'json' => [
                "car"=> [
                    "id" => $car->getId(),
                ],
                "user"=> [
                    "id" => $user->getId(),
                ],
                "startDate"=>"2024-07-20 16:32:49",
                "endDate"=>"2024-07-20 20:32:49"
            ],
        ]);
        $this->assertResponseStatusCodeSame(201);
    }
}