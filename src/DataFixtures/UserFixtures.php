<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

       for($i =1;$i<=10;$i++)
       {
           $user = new User();
           
           $user->setUsername($faker->username())
                ->setUserlastname($faker->lastName())
                ->setAge($faker->numberBetween($min=1,$max=120))
                ->setSex($faker->randomElement($array = array('F','M')))
                ->setAdress($faker->streetAddress)
                ->setTown($faker->country)
                ->setPostcode(75000)
                ->setPhone($faker->phoneNumber)
                ->setMail($faker->email)
                ->setNationality($faker->city)
                ->setRoles($faker->randomElement($array = array('Admin','Professionnel','Visiteur')))
                ->setPassword($faker->password);
                

           $manager->persist($user);
           
       }//fin du for

       $manager->flush();//fait l'insertion en BDD
    }
}
