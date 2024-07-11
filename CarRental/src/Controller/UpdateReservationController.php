<?php

namespace App\Controller;

use ApiPlatform\Validator\Exception\ValidationException;
use App\Entity\Reservation;
use App\Services\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateReservationController extends AbstractController
{
    public function __construct(private ValidatorInterface $validator, private BookingService $bookingService)
    {
    }
    /**
     * @throws \Exception
     */
    public function __invoke(Reservation $data, int $id): JsonResponse
    {
        $errors = $this->validator->validate($data);
        if ($errors->count()) {
            throw new ValidationException($errors);
        }

        $connectedUser = $this->getUser();
        if ($connectedUser->getId() !== $data->getUser()->getId()) {
            throw new UnauthorizedHttpException('', 'UNAUTHORIZED');
        }

        $this->bookingService->updateUserReservation($data, $id);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
