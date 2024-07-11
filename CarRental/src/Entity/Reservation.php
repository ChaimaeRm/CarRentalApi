<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\BookCarController;
use App\Controller\DeleteReservationController;
use App\Controller\UpdateReservationController;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;

#[ApiResource(
    operations: [
        new Post(
            controller: BookCarController::class,
            denormalizationContext: ['groups' => ['bookCar']],
        ),
        new Put(
            controller: UpdateReservationController::class,
            denormalizationContext: ['groups' => ['bookCar']],
            read: false
        ),
        new Delete(
            controller: DeleteReservationController::class,
        )
    ]
)]
#[ORM\Entity]
#[CustomAssert\EndDateConstraint]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull]
    #[Groups(['bookCar'])]
    private \DateTime $startDate;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull]
    #[Groups(['bookCar'])]
    private \DateTime $endDate;

    #[ORM\ManyToOne(targetEntity: Car::class)]
    #[ORM\JoinColumn(name: 'car_id', referencedColumnName: 'id', nullable: false)]
    #[Assert\NotNull]
    #[Groups(['bookCar'])]
    private Car $car;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[Assert\NotNull]
    #[Groups(['bookCar'])]
    private User $user;

    public function getId(): int
    {
        return $this->id;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function setCar(Car $car): void
    {
        $this->car = $car;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
