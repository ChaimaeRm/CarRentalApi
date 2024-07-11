<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Services\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DeleteReservationController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function __invoke(Reservation $data, BookingService $bookingService)
    {
        $connectedUser = $this->getUser();
        if ($connectedUser->getId() !== $data->getUser()->getId()) {
            throw new UnauthorizedHttpException('', 'UNAUTHORIZED');
        }

        $bookingService->DeleteMyReservation($data);

        return new JsonResponse([],Response::HTTP_NO_CONTENT);
    }
}
