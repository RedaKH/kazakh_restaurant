<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route(path: '/error_403', name: 'error')]

    public function error_403(KernelInterface $kernel, Request $request): Response
{
    // Si l'environnement est "prod" et que l'utilisateur n'a pas les droits appropriés
    if ($kernel->getEnvironment() === 'prod' && !$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_LIVREUR') && !$this->isGranted('ROLE_EMPLOYE')) {
        throw $this->createAccessDeniedException();
    }

    // Logique de votre action

    return new Response('Contenu de la page');
}

}

