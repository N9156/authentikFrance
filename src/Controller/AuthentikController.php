<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Category;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Entity\SiteTouristique;
use Doctrine\ORM\EntityManager;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use App\Repository\SiteTouristiqueRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthentikController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('authentik/home.html.twig', [
            'controller_name' => 'AuthentikController',
        ]);
    }

// Liste tous les sites touristiques
    /**
     * @Route("/authentik", name="authentik")
     */
    public function index(SiteTouristiqueRepository $repo, CategoryRepository $repoCat)
    { 
        $cat = $repoCat->findAll();
        $sites = $repo->findAll();
    
         dump($sites);
         dump($cat);

        return $this->render('authentik/index.html.twig', [
         'sites' => $sites,
         'category' => $cat   
        ]);
    }

//Liste des sites x category
    /**
     * @Route("/authentik_liste/{id}", name="authentik_liste")
     */
    public function listeXcategory(CategoryRepository $repo, $id, SiteTouristiqueRepository $reposit)
     {   
        $cat = $repo->findAll();
        $category= $repo->find($id);
        $site = $reposit->findBy(array('category' => $category));

         dump($site);
         dump($cat);
         dump($category);

        return $this->render('authentik/sitesxcategory.html.twig', [
            'category' => $cat,
            'category_liste' => $site,
            'category_title'=> $category
            ]);
    }


    /**
    * @Route("/authentik/contact", name="authentik_contact")
    */
    public function contact(Request $request, EntityManagerInterface $manager, ContactNotification $notification)
    {
        $contact = new Contact;

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notification->notify($contact);

            $this->addFlash('success', 'Votre Email a bien été envoyé');

            $manager->persist($contact); // on prépare l'insertion
            $manager->flush(); // on execute l'insertion

        }

        return $this->render("authentik/contact.html.twig", [
            'formContact' => $form->createView()
        ]);
    }

     // 1 Site en particuliere et commentaire et liste de tous les commentaires //
    /**
    * @Route("/authentik/{id}", name="authentik_show")
    * 
    */
    public function show(SiteTouristiqueRepository $repo, $id, Request $request, EntityManagerInterface $manager)
    {
        $site = $repo->find($id);
    
        // dump($site);

        $commentaire = New Comment();
        
        $form_comment = $this->createForm(CommentType::class, $commentaire);
        $form_comment->handleRequest($request);
        
        if($form_comment->isSubmitted() && $form_comment->isValid())
        {
            $commentaire->setCreatedAt(new \DateTime());

            $commentaire->setSiteTouristiques($site);

            $manager->persist($commentaire); 
            $manager->flush(); 

            $this->addFlash('success', 'Merci ! Votre commentaire a été bien prise en compte');
        }

        return $this->render('authentik/show.html.twig', [
            'site' => $site,
            'formComment'=> $form_comment->createView()
        ]);
    }
     
}

