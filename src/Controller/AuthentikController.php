<?php

namespace App\Controller;

use App\Repository\SiteTouristiqueRepository;
use App\Entity\SiteTouristique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthentikController extends AbstractController
{
    /**
     * @Route("/authentik", name="authentik")
     */
    public function index()
    {
        return $this->render('authentik/index.html.twig', [
            'controller_name' => 'AuthentikController',
        ]);
    }

    //liste tout de chaque categorie
    /**
     * @Route("/authentik/accueil"), name="accueil")
     */

    public function liste(SiteTouristiqueRepository $repo)
    { 
        $sites_gastronomie = $repo->findByCategory('gastronomie'); 
        $sites_artisan = $repo->findByCategory('artisan'); 
        $sites_restaurateur = $repo->findByCategory('restaurateur');
        $sites_autres = $repo->findByCategory('autres');

        // dump($sites);

        return $this->render('authentik/accueil.html.twig', [
            'sites_gastronomie' => $sites_gastronomie,
            'sites_artisan' => $sites_artisan,
            'sites_restaurateur' => $sites_restaurateur,
            'sites_autres' => $sites_autres
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
