<?php

namespace App\DataFixtures;

use App\Entity\SiteTouristique;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SitesTouristiquesFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

         // creation des Users
         for ($l =1; $l<=10; $l++)
         {
             $user = New User;
 
             $user ->setUsername($faker->firstName($gender = null))
                   ->setUserlastname($faker->lastName)
                   ->setAge($faker->numberBetween($min = 1, $max = 120))
                   ->setSex($faker->randomElement($array = array ('F','M')))
                   ->setAdress($faker->streetAddress)
                   ->setTown($faker->country)
                   ->setPostcode($faker->postcode)
                   ->setPhone($faker->e164PhoneNumber)
                   ->setMail($faker->email)
                   ->setNationality($faker->city)
                   ->setRoles($faker->randomElement($array = array ('Admin','Professionnel','Visiteur')))
                   ->setPassword($faker->password);
 
             $manager->persist($user);
 
         }

        // Création de 4 catégories
        for($i = 1; $i <= 4; $i++)
        {
        
            $category = new Category;

            $category->setTitle($faker->randomElement($array = array ('Gastronomie','Artisan','Restaurateur','Autres')))
                     ->setDescription($faker->text($maxNbChars = 50));

            $manager->persist($category); 
            

            // création entre 4 et 6 sites par catégorie
            for($j = 1; $j <= mt_rand(4,6); $j++)
            {   

                 $site = new SiteTouristique;
 
                 $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>'; 
 
                 $site->setTitle($faker->sentence()) 
                      ->setContent($content) 
                      ->setImage($faker->imageUrl()) 
                      ->setAdress($faker->address)
                      ->setPhone($faker->e164PhoneNumber)
                      ->setMail($faker->email)
                      ->setContactProfessionnel($faker->lastname)
                      ->setUrl($faker->url)
                      ->setPublication($faker->randomElement($array = array ('0','1')))
                      ->setUser($user)
                      ->setCategory($category);
                         
                 $manager->persist($site); 
                 

                // Création entre 4 et 10 commentaires par site
                for($k = 1; $k <= mt_rand(4,10); $k++)
                {
                    $comment = new Comment;

                    $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>'; 
                    
                    $now = new \Datetime;
                
                    $comment->setAuthor($faker->lastName)
                            ->setContent($content) 
                            ->setCreatedAt($faker->dateTime($max = 'now', $timezone = null))
                            ->setUsers($user)
                            ->setSiteTouristiques($site);
                        
                    $manager->persist($comment); 
                }
            }
    
        }

        $manager->flush(); 
    }
}
