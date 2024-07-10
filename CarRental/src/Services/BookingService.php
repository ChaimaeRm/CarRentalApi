<?php

namespace App\Services;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Response;

class BookingService
{
    public function __construct(private ReservationRepository $reservationRepository)
    {
    }

    public function bookCarForUser(Reservation $reservation): Reservation
    {
        $existingBookings = $this->reservationRepository->checkExistingReservation(
            $reservation->getCar(),
            $reservation->getStartDate(),
            $reservation->getEndDate()
        );

        if ($existingBookings) {
            throw  new \Exception('this Car already booked! choose another one', Response::HTTP_CONFLICT);
        }

        $this->reservationRepository->persist($reservation);

        return $reservation;
    }
}
