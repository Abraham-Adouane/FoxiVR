<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('abr01@live.fr');
        $admin->setLastname('Adouane');
        $admin->setFirstname('Abraham');
        $admin->setAddress('30 de laHaut');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, '123123')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Factory::create('fr_FR');
        for ($usr = 1; $usr <= 5; $usr++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setLastname($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setAddress($faker->streetAddress());
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
