<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Entity\SiteTouristique;
use App\Form\SiteTouristiqueType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistance\ManagerRegistry;
use App\Repository\SiteTouristiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

   /**
     * @Route("/user", name="user")
     */
    public function user()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController'
        ]);
    }



// CONTROLLER SITES TOURISTIQUES
     /**
      * @Route("/user", name="user")
      */
     public function index(SiteTouristiqueRepository $repo)
     {
         // Liste de tout les sites turistiques qui correspondent au professionnel

         $sit = $this->getDoctrine()->getManager();
 
         $colonnes_sites = $sit->getClassMetadata(SiteTouristique::class)->getFieldNames();
 
         dump($colonnes_sites);
 
         $comments_sites = $repo->findAll();
 
         dump($comments_sites);
         
         return $this->render('user/user_sites_touristiques.html.twig', [
             'comments_sites' => $comments_sites,
             'colonnes_sites' => $colonnes_sites,
        ]);
    }

    /**
     * @Route("/user/site_touristique/new", name="user_new_site")
     * @Route("/user/{id}/edit_site_touristique", name="user_edit_site")
     */
    public function editSite(SiteTouristique $site = null, Request $request, EntityManagerInterface $manager)
    {
        dump($site);

       // $lastUsername = $authenticationUtils->getLastUsername(); + , AuthenticationUtils $lastUsername, $authenticationUtils EN METHODE
        
        //dump($lastUsername);

        if(!$site)
        {
            $site = new SiteTouristique;
        }

        $formSite= $this->createForm(SiteTouristiqueType::class, $site);


        $formSite->handleRequest($request);

        if($formSite->isSubmitted() && $formSite->isValid()) 
        {   
            if(!$site->getId());

           // $site->setUser($lastUsername);  SETTER USERNAME!
            
            $manager->persist($site);  
            $manager->flush(); 

            $this->addFlash('success', 'Les modifications ont bien été enregistrées !');

            // return $this->redirectToRoute('admin_articles');
        }

        return $this->render('user/user_edit_site_touristique.html.twig', [
            'formSite' => $formSite->createView(),
            'editMode' => $site->getId() !== null
        ]);
    }


    /**
     * @Route("admin/{id}/delete-site", name="user_delete_site")
     */
    public function deleteSite(SiteTouristique $site, EntityManagerInterface $manager)
    {
        $manager->remove($site);
        $manager->flush();

        $this->addFlash('success', "Le Site Touristique a bien été supprimé !");

        return $this->redirectToRoute('user');
    }

    
    
}//fin class
