<?php

namespace App\Controller;

use ApiPlatform\Validator\Exception\ValidationException;
use App\Entity\Reservation;
use App\Services\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookCarController extends AbstractController
{
    public function __construct(private ValidatorInterface $validator, private BookingService $bookingService)
    {
    }
    /**
     * @throws \Exception
     */
    public function __invoke(Reservation $data): JsonResponse
    {
        $errors = $this->validator->validate($data);
        if ($errors->count()) {
            throw new ValidationException($errors);
        }

        $reservation = $this->bookingService->bookCarForUser($data);

        return new JsonResponse($reservation, Response::HTTP_CREATED);
    }
}
