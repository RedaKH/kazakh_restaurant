<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LanguageController extends AbstractController
{
    #[Route('/change-locale/{locale}', name: 'change_locale')]
    public function changeLocale($locale, Request $request, SessionInterface $session): Response
    {
         // Enregistre la langue choisie dans la session
         $session->set('_locale', $locale);

         // Redirige l'utilisateur vers la page précédente ou la page d'accueil s'il n'y a pas de page précédente
         $referer = $request->headers->get('referer');
         return $this->redirect($referer ?: $this->generateUrl('accueil'));
    }
}
