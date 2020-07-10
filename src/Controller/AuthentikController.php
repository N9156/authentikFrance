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

    //liste tout les sites touristiques de chaque categorie
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
    
    /**
    * @Route("/authentik/contact", name="authentik_contact")
    */
    public function contact(Request $request, EntityManagerInterface $manager, ContactNotification $notification)
    {
        $contact = new Contact;

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
                    dump($contact);
                    dump($request);

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

    /// New commentaire

    /**
     * @Route("/authentik/new_commentaire", name="authentik_commentaire")
     *
     */

    public function create(Request $request, EntityManagerInterface $manager)
    {
        $commentaire = New Comment();

        $form_comment = $this->createForm(CommentType::class, $commentaire);
        $form_comment->handleRequest($request);
        
        if($form_comment->isSubmitted() && $form_comment->isValid())
        {
            $commentaire->setCreatedAt(new \DateTime());
            $manager->persist($commentaire); 
            $manager->flush(); 

            $this->addFlash('success', 'Merci ! Votre commentaire a été bien prise en compte');
 
        }
            return $this->render('authentik/new_commentaire.html.twig', [
                'formComment'=> $form_comment->createView()
            ]);
    }

          
    // 1 Site en particuliere //
    /**
    * @Route("/authentik/{id}", name="authentik_show")
    * 
    */
    public function show(SiteTouristiqueRepository $repo, $id)
    {
        $site = $repo->find($id);

        dump($site);

        return $this->render('authentik/show.html.twig', [
            'site' => $site
        ]);
    }

     
}

