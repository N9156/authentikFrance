<?php

namespace App\Controller;

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

    /**
     * @Route("/authentik/accueil"), name="accueil")
     */

    public function liste()
    {
        return $this->render('authentik/accueil.htlm.twig');
    }

}
