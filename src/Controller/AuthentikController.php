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
}
