<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/accueil', name: 'accueil')]
    public function accueil(BlogRepository $blogRepository): Response
    {
        $blogs = $blogRepository->findBy([], ['created_at' => 'DESC'], 2);
        return $this->render('accueil.html.twig', [
            'blogs' => $blogs,
        ]);
    }
    #[Route('/menu', name: 'menu')]
    public function menu(): Response
    {
        return $this->render('menu.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    #[Route('/privatisation', name: 'privatisation')]
    public function privatisation(): Response
    {
        return $this->render('privatisation.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    #[Route('/surplace', name: 'surplace')]
    public function surplace(): Response
    {
        return $this->render('surplace.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    #[Route('/emporter', name: 'emporter')]
    public function emporter(): Response
    {
        return $this->render('emporter.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    #[Route('/livraison', name: 'livraison')]
    public function livraison(): Response
    {
        return $this->render('livraison.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}

