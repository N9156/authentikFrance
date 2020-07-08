<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistance\ManagerRegistry;
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
    /**
     * @Route("/user/new", name="user_create")
     */
    public function create(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder)
    {
        //dump($request);
        //if(!$user){
        $user=new User;
        //}//fin if
        //dump($request);
        $form=$this->createForm(UserType::class,$user);
        //dump($request);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(["ROLE_USER"]);
           $manager->persist($user);
           $manager->flush();
           //dump($user);
           $this->addFlash('success','Félicitations !! Vous êtes maintenant inscrit, vous pouvez maintenant vous connecter.');
           //return $this->redirectToRoute('security_login');//pour rediriger apres inscription vers la page connexion

        }//fin if
        return $this->render('user/create.html.twig', [
            'formUser' =>$form->createView()
        ]);
        //dump($user);
    }//fin create  creation formulaire
    
}
