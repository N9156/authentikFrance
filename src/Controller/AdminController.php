<?php

namespace App\Controller;

use App\Entity\Comment;

use App\Entity\Contact;
use App\Entity\SiteTouristique;
use App\Form\SiteTouristiqueType;
use App\Repository\CommentRepository;
use App\Repository\ContactRepository;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Entity\SiteTouristique;
use App\Form\SiteTouristiqueType;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SiteTouristiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

// CONTROLLER SITES TOURISTIQUES

    /**
     * @Route("/admin/admin_sites_touristiques", name="admin_sites_touristiques")
     */
    public function adminSitesTouristiques(SiteTouristiqueRepository $repo)
    {   
        $sit = $this->getDoctrine()->getManager();

        $colonnes_sites = $sit->getClassMetadata(SiteTouristique::class)->getFieldNames();

        dump($colonnes_sites);

        $comments_sites = $repo->findAll();

        dump($comments_sites);
        
        return $this->render('admin/admin_sites_touristiques.html.twig',[
            'comments_sites' => $comments_sites,
            'colonnes_sites' => $colonnes_sites

        ]);
    }

    /**
     * @Route("/admin/site_touristique/new", name="admin_new_site")
     * @Route("/admin/{id}/edit_site_touristique", name="admin_edit_site")
     */
    public function editSite(SiteTouristique $site = null, Request $request, EntityManagerInterface $manager)
    {
        dump($site);

        if(!$site)
        {
            $site = new SiteTouristique;
        }

        $formSite = $this->createForm(SiteTouristiqueType::class, $site);

        $formSite->handleRequest($request);

        if($formSite->isSubmitted() && $formSite->isValid()) 
        {   
            if(!$site->getId())
            // {
            //     $article->setCreatedAt(new \DateTime);
            // }

            $manager->persist($site);  
            $manager->flush(); 


            $this->addFlash('success', 'Les modifications ont bien été enregistrées dans la BDD !');


            return $this->redirectToRoute('admin_sites_touristiques');
        }

        return $this->render('admin/admin_edit_site_touristique.html.twig', [
            'formSite' => $formSite->createView(),
            'editMode' => $site->getId() !== null
        ]);
    }

    /**
     * @Route("admin/{id}/delete-site_touristique", name="admin_delete_site")
     */
    public function deleteSite(SiteTouristique $site_touristique, EntityManagerInterface $manager)
    {
        $manager->remove($site_touristique);
        $manager->flush();

        $this->addFlash('success', "Le Site Touristique a bien été supprimé de la BDD !");

        return $this->redirectToRoute('admin_sites_touristiques');
    }

// CONTROLLER COMMENTAIRES

// CONTROLLER CATEGORIES

/**
* @Route("/admin/category", name="admin_category")
*/
    public function adminCategory(CategoryRepository $repo)
    {
        $em = $this->getDoctrine()->getManager();

        
        $colonnes = $em->getClassMetadata(Category::class)->getFieldNames();

        dump($colonnes);

        $category = $repo->findAll();

        dump($category);

        return $this->render('admin/admin_categories.html.twig', [
            'category' => $category,
            'colonnes' => $colonnes
        ]);
    }

/**
* @Route("/admin/category/new", name="admin_new_category")
* @Route("/admin/{id}/edit-category", name="admin_edit_category")
*/
    public function editCategory(Category $category = null, EntityManagerInterface $manager, Request $request)
    {
        if(!$category)
        {
            $category = new Category;
        }

        dump($category);
        dump($category->getSitestouristiques());

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {   
            $manager->persist($category);  
            $manager->flush(); 

            $this->addFlash('success', 'Les modifications ont bien été enregistrées dans la BDD !');

            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/admin_edit_categorie.html.twig', [
            'formCategory' => $form->createView(),
            'editMode' => $category->getId() !== null
        ]);
    }

/**
* @Route("admin/{id}/delete-category", name="admin_delete_category")
*/
    public function deleteCategory(Category $category, EntityManagerInterface $manager)
    {
        dump($category->getSitestouristiques());

        if($category->getSitestouristiques()->isEmpty())
        {
            $manager->remove($category);
            $manager->flush();

            $this->addFlash('success', "La catégorie a bien été supprimé de la BDD !");

            return $this->redirectToRoute('admin_category');
        }
        else
        {
            $this->addFlash('danger', "Des sites touristiques sont encore associé à la catégorie, il est donc impossible de la supprimer !");

            return $this->redirectToRoute('admin_category');
        }
    }

// CONTROLLER COMMENTAIRES

     /**
     * @Route("/admin/comments", name="admin_comments")
     */
    public function adminComments(CommentRepository $repo)
    {
        // On appel getManager afin de récupérer le noms des champs et des colonnes
        $em = $this->getDoctrine()->getManager();

        // récupération des champs
        $colonnes = $em->getClassMetadata(Comment::class)->getFieldNames();

        dump($colonnes);

        $comments = $repo->findAll();

        dump($comments);

        return $this->render('admin/admin_comments.html.twig', [
            'comments' => $comments,
            'colonnes' => $colonnes
        ]);
    }

    /**
     * @Route("admin/{id}/delete-comment", name="admin_delete_comment")
     */
    public function deleteComment(Comment $comment, EntityManagerInterface $manager)
    {
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash('success', "Le commentaire a bien été supprimé de la BDD !");

        return $this->redirectToRoute('admin_comments');
    }

    /**
     * @Route("/admin/admin_contacts", name="admin_contacts")
     */
    public function adminContacts(ContactRepository $repo)
    {
        $em = $this->getDoctrine()->getManager();
        $colonnes = $em->getClassMetadata(Contact::class)->getFieldNames();
        $contacts = $repo->findAll();
        dump($contacts);
        dump($colonnes);
        return $this->render('admin/admin_contacts.html.twig', [
            'contacts' => $contacts,
            'colonnes' => $colonnes
        ]);
    }//fin adminContacts methode qui retourne les contacts
    }//fin class AdminController




}


