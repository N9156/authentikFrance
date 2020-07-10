<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create('fr_FR');
      
        for($i =1;$i<=10;$i++)
        {
            $contact = new Contact();
            
            $contact->setFirstname($faker->username())
                    ->setLastname($faker->lastName())                         
                    ->setPhone($faker->phoneNumber)
                    ->setEmail($faker->email)
                    ->setMessage($faker->text($maxNbChars = 200));
  
            $manager->persist($contact);
            
        }//fin du for
 
        $manager->flush();//fait l'insertion en BDD
     }
 }
    

    
