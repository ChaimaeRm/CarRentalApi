<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Car;
use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null findOneById(int $id)
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $data, bool $persist = true): void
    {
        if ($persist) {
            $this->getEntityManager()->persist($data);
        }

        $this->getEntityManager()->flush();
    }

    public function checkExistingReservation(Car $car, \DateTime $startDate, \DateTime $endDate, ?int $id = null)
    {
        $qb = $this->createQueryBuilder('r');
        if ($id) {
            $qb->where('r.id <> :id')
            ->setParameter('id', $id);
        }

        $query = $qb->andWhere('r.car = :carId')
         ->andWhere($qb->expr()->orX(
             $qb->expr()->between(':startDate', 'r.startDate', 'r.endDate'),
             $qb->expr()->between(':endDate', 'r.startDate', 'r.endDate'),
             $qb->expr()->andX(
                 $qb->expr()->lt('r.startDate', ':startDate'),
                 $qb->expr()->gt('r.endDate', ':endDate')
             )
         ))
         ->setParameter('carId', $car)
         ->setParameter('startDate', $startDate)
         ->setParameter('endDate', $endDate)
         ->getQuery();

        return (bool) $query->getResult();
    }

    public function delete(Reservation $reservation): void
    {
        $this->getEntityManager()->remove($reservation);
        $this->getEntityManager()->flush();
    }
}
