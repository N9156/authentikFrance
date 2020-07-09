<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Doctrine\Persistance\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/pageuser.html.twig', [
            'title' => 'Bienvenue sur la page des utilisateurs'

        ]);
    }
    
}
