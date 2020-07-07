<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Category;
use App\Form\ContactType;
use App\Entity\SiteTouristique;
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

    //liste tout de chaque categorie
    /**
     * @Route("/authentik", name="authentik")
     */

    public function index(SiteTouristiqueRepository $repo, CategoryRepository $repoCat)
    { 
        // $sites_gastronomie = $repo->findByCategory('gastronomie'); 
        // $sites_artisan = $repo->findByCategory('artisan'); 
        // $sites_restaurateur = $repo->findByCategory('restaurateur');
        // $sites_autres = $repo->findByCategory('autres');

        $cat = $repoCat->findAll();

        $sites = $repo->findAll();


        dump($sites);
        dump($cat);

        return $this->render('authentik/index.html.twig', [
            'sites' => $sites,
            'category' => $cat
            
            // 'sites_gastronomie' => $sites_gastronomie,
            // 'sites_artisan' => $sites_artisan,
            // 'sites_restaurateur' => $sites_restaurateur,
            // 'sites_autres' => $sites_autres
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

    // show() 
    /**
     * @Route("/authentik/{id}", name="authentik_show")
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
    