<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LanguageController extends AbstractController
{
    #[Route('/change-locale/{locale}', name: 'change_locale')]
    public function changeLocale(string $locale,Request $request): Response
    {
        $request->getSession()->set('__locale',$locale);
        $referer = $request->headers->get('referer');

        return $this->redirect($referer ?:$this->generateUrl('homepage'));
    }
}
