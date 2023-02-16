<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{
    //constructeur pour hacher les mots de passe
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@demo.fr');
        $admin->setLastname('Fernandez');
        $admin->setFirstname('Silvia');
        $admin->setAddress('80 allée F');
        $admin->setZipcode('13760');
        $admin->setCity('Saint Cannat');
        $admin->setPassword(
            //methode hashPassword
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        //Donner le role Administarteur
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');
        for ($usr = 1; $usr <= 5; $usr++) {
            $user = new Users();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ', '', $faker->postcode));
            $user->setCity($faker->city);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );
            $manager->persist($user);
        }


        $manager->flush();
    }
}
