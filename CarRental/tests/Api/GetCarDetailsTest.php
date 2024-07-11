<?php

namespace Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\CarRepository;
use App\Repository\ReservationRepository;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetCarDetailsTest extends ApiTestCase
{

    private CarRepository $carRepository;
    private ReservationRepository $reservationRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Get the entity manager and repository
        $this->carRepository = self::getContainer()->get(CarRepository::class);
        $this->reservationRepository = self::getContainer()->get(ReservationRepository::class);
    }
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    function testGetCarDetails()
    {
        $client = static::createClient();
        $loginResponseContent = checkLoginTest::getLoginToken($client)->getContent();
        $token = isset(json_decode($loginResponseContent, true)['token']) ?
            json_decode($loginResponseContent, true)['token']
            : null;
        
        $car = $this->carRepository->findOneBy(['registrationNumber' => 'DEF-9012']);

        $response = $client->request('GET', '/api/cars/'. $car->getId(), [
            'headers' => [
                'Authorization' => 'Bearer '. $token,
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals('Ford',json_decode($response->getContent(), true)['brand']);
    }
}