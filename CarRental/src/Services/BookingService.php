<?php

namespace App\Services;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingService
{
    public function __construct(private ReservationRepository $reservationRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function bookCarForUser(Reservation $reservation): Reservation
    {
        $this->checkReservationExists($reservation);
        $this->reservationRepository->save($reservation);

        return $reservation;
    }

    /**
     * @throws \Exception
     */
    public function updateUserReservation(Reservation $reservation, int $currentReservationId): Reservation
    {
        $currentReservation = $this->reservationRepository->findOneById($currentReservationId);

        if (!$currentReservation) {
            throw new NotFoundHttpException('Reservation not found');
        }

        $this->checkReservationExists($reservation, $currentReservationId);
        // update current Reservation Infos
        $currentReservation->setCar($reservation->getCar());
        $currentReservation->setStartDate($reservation->getStartDate());
        $currentReservation->setEndDate($reservation->getEndDate());
        $this->reservationRepository->save($reservation, false);

        return $reservation;
    }

    private function checkReservationExists(Reservation $reservation, ?int $currentReservationId = null): void
    {
        $existingBookings = $this->reservationRepository->checkExistingReservation(
            $reservation->getCar(),
            $reservation->getStartDate(),
            $reservation->getEndDate(),
            $currentReservationId
        );

        if ($existingBookings) {
            throw  new \Exception(
                'this Car already booked! choose another one or another Date',
                Response::HTTP_CONFLICT
            );
        }
    }

    public function deleteMyReservation(Reservation $reservation): void
    {
        $this->reservationRepository->delete($reservation);
    }
}
