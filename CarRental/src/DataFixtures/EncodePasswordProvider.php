<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Generator;
use Faker\Provider\Base;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EncodePasswordProvider extends Base
{
    public function __construct(Generator $generator, private UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($generator);
    }

    public function encodePassword(string $password): string
    {
        return $this->passwordHasher->hashPassword(new User(), $password);
    }
}
