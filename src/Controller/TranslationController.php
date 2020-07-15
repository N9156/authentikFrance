<?php

namespace App\Controller;

use App\Controller\TranslationController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TranslationController extends AbstractController
{
    /**
     * @Route("/translation", name="translation")
     */
    public function index(TranslatorInterface $translator)
    {
        $message = $translator->trans('Your comment is pending approval');
    
        // ...
    
    
        return $this->render('translation/index.html.twig', [
            'controller_name' => 'TranslationController',
        ]);
    }


/**
 * @Route("/change_locale/{locale}", name="change_locale")
 */
public function changeLocale($locale, Request $request)
{
    // On stocke la langue dans la session
    $request->getSession()->set('_locale', $locale);

    // On revient sur la page précédente
    return $this->redirect($request->headers->get('referer'));
}

}