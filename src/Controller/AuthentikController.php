<?php

namespace App\Controller;

use App\Repository\SiteTouristiqueRepository;
use App\Entity\SiteTouristique;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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

    // show() 
    /**
     * @Route("/authentik/{id}", name="authentik_show")
     */
    public function show(SiteTouristiqueRepository $repo, $id)
    {
        $site = $repo->find($id);

        // dump($article);

        return $this->render('authentik/show.html.twig', [
            'site' => $site
        ]);
    }
    

}
/**
* @Route("/blog/contact", name="blog_contact")
*/
        public function contact(Request $request, EntityManagerInterface $manager)
    {
            $contact = new Contact();
            $form = $this->createForm(ContactType::class, $contact);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($contact); // on prépare l'insertion
            $manager->flush(); // on execute l'insertion
            }
        return $this->render("blog/contact.html.twig", [
        'formContact' => $form->createView()
        ]);
    }