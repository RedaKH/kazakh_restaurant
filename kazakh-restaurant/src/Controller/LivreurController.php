<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LivreurController extends AbstractController
{
    #[Route('/livreur/dashboard', name: 'livreur_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('livreur/dashboard.html.twig');
    }
}
