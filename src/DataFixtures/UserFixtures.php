<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UserFixtures extends Fixture
{
    //constructeur pour hacher les mots de passe. Avec la propiété UserPasswordHasserInterface
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
    ) {
    }

    public function load(ObjectManager $manager): void
    { //Instantiation d'user
        $admin = new User();
        $admin->setEmail('admin@demo.fr');
        $admin->setLastname('Fernandez');
        $admin->setFirstname('Silvia');
        $admin->setAddress('80 allée');
        $admin->setZipcode('13760');
        $admin->setCity('Saint Cannat');
        $admin->setPassword(
            //methode hashPassword(user, mot de passe)
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        //Donner le role Administarteur
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');
        for ($usr = 1; $usr <= 5; $usr++) {
            $user = new User();
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

        //inscrire dans la base de données
        $manager->flush();
    }
}
