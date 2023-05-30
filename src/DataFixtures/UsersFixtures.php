<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;


class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder,
    private SluggerInterface $slugger){}
    public function load(ObjectManager $manager): void
    {
        $user = new Users();
        $user->setEmail('user@demo.com');
        $user->setLastname('ghassen');
        $user->setFirstname('benhammadi');
        $user->setAddress('rue de sousse');
        $user->setZipcode('4200');
        $user->setCity('Kébili');
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'admin'));

        $manager->persist($user);
        $faker = Faker\Factory::create('fr_FR');

        for($usr =1; $usr <= 5; $usr++){
            $user = new Users();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ', '', $faker->postcode));
            $user->setCity($faker->city);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'secret'));
            
            $manager->persist($user);

        }

        $manager->flush();
    }
}
