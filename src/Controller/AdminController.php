<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\SiteTouristique;
use App\Repository\CommentRepository;
use App\Repository\SiteTouristiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
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
     * @Route("admin/{id}/delete-site_touristique", name="admin_delete_site")
     */
    public function deleteSite(SiteTouristique $site_touristique, EntityManagerInterface $manager)
    {
        $manager->remove($site_touristique);
        $manager->flush();

        $this->addFlash('success', "Le Site Touristique a bien été supprimé de la BDD!");

        return $this->redirectToRoute('admin_sites_touristiques');
    }


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

        $this->addFlash('success', "Le commentaire a bien été supprimé de la BDD!");

        return $this->redirectToRoute('admin_comments');
    }


}

