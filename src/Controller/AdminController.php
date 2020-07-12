<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /*
    /**
     * @Route("/admin/)
     */
    /*public function affichuser(UserRepository $repo)//injection de dependance
    {
        $users=$repo->findAll();
        dump($articles);

        return $this->render('admin/affuser.html.twig',[
            'controller_name' => 'AdminController',
            'utilisateurs' =>$users
        ]);
    }//fin affichuser*/
}
