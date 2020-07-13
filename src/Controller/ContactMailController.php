<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactMailController extends AbstractController
{
    /**
     * @Route("/authentik/contact/mail", name="contact_mail")
     */
    public function adminMail(ContactRepository $repo)
    {
        $contacts = $repo->findAll();

        dump($contacts);

        return $this->render('contact_mail/index.html.twig', [
            'contacts' => $contacts
        ]);
    }
}
