<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();
        $faker->addProvider(new EncodePasswordProvider($faker, $this->passwordHasher));

        $loader = new NativeLoader($faker);
        $objectSet = $loader->loadFiles([
            __DIR__ . '/fixtures/user.yaml',
            __DIR__ . '/fixtures/car.yaml',
            __DIR__ . '/fixtures/reservation.yaml',
        ])->getObjects();
        foreach ($objectSet as $object) {
            $manager->persist($object);
        }

        $manager->flush();
    }
}
