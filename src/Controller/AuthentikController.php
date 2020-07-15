<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Category;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Entity\SiteTouristique;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Doctrine\Persistance\ManagerRegistry;
use App\Repository\SiteTouristiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    /**
     * @Route("/authentik/create", name="authentik_create")
     */
    public function create(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder)
    {
        dump($request);
        //if(!$user){
        $user=new User;
        //}//fin if
        //dump($request);
        $form=$this->createForm(UserType::class,$user);
        //dump($request);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            /*foreach($roles as $cle=>$value){$roles[$cle];}*/
            /*foreach($this.roles as $cle=>$value){
            $user->setRoles([$value]);}*/
            //$data = $request->$form->getRoles();
            /*dump($data);*/

            //$user->setRoles(["ROLE_USER"]);
            //$data['roles'];

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            
           $manager->persist($user);
           $manager->flush();
        //    dump($request);
           $this->addFlash('success','Félicitations !! Vous êtes maintenant inscrit, vous pouvez maintenant vous connecter.');
           return $this->redirectToRoute('authentik_login');//pour rediriger apres inscription vers la page connexion

        }//fin if
        return $this->render('authentik/create.html.twig', [
            'formUser' =>$form->createView()
        ]);
        //dump($user);
    }//fin create  creation formulaire

    /**
     * @Route("/connexion", name="authentik_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //renvoie le message d'erreur en cas de mauvaise connexion, si l'internaute a saisi des identifiants incorrects au moment de la connexion
        $error = $authenticationUtils->getLastAuthenticationError();

        //permet de récuperer le dernier username (email) que l'internaute a saisie dans le formulaire de connexion en cas d'erreur de connexion
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('authentik/login.html.twig',[
                'last_username' => $lastUsername, //on envoie le message d'erreur et le dernier email saisie sur le template
                'error' => $error
                ]);
    }//fin login

    /**
     * @Route("/deconnexion", name="authentik_logout")
     */
    public function logout()
    {
        //cette methode ne retourne rien, il nous suffit d'avoir une route pour la deconnexion
    }//fin logout*/


    // show() 

     // 1 Site en particuliere et commentaire et liste de tous les commentaires //

    /**
    * @Route("/authentik/{id}", name="authentik_show")
    * 
    */
    public function show(SiteTouristiqueRepository $repo, $id, Request $request, EntityManagerInterface $manager)
    {
        $site = $repo->find($id);
    
        dump($site);

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

