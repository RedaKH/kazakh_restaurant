<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Entity\Reservation;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class EmployeController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ClientRepository $clientRepository;

    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
    }

    #[Route('/admin/new', name: 'add_employe')]
    public function add_employe(Request $request, UserPasswordHasherInterface $passwordhasher): Response
    {
        $employe = new Employe();
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $passwordhasher->hashPassword(
                $employe,
                $employe->getPassword()
            );
            $employe->setPassword($hashedPassword);

            $this->entityManager->persist($employe);
            $this->entityManager->flush();

            return $this->redirectToRoute('add_employe');
        }

        return $this->render('employe/add_employe.html.twig', [
            'employe' => $employe,
            'form' => $form->createView()
        ]);
    }

    #[Route('/employe/dashboard', name: 'employe_dashboard')]
    public function dashboard(): Response
    {
        $reservations = $this->entityManager->getRepository(Reservation::class)->findAll();
        $employe = $this->getUser();

        return $this->render('employe/dashboard.html.twig', [
            'reservations' => $reservations,
            'employe'=>$employe
        ]);
    }


    #[Route('/livreur/dashboard', name: 'livreur_dashboard')]

    public function verifyCodeLivraison(Request $request): Response
    {
        $clientId = $request->request->get('client_id');
        $codecli = $request->request->get('code_cli');

        $isValid = $this->clientRepository->validateCode((int)$clientId, (int)$codecli);
        if ($isValid) {
            // si le code est valide donc mettre à jour la livraison

            $this->addFlash('success', 'le code de livraison est valide. Livraison confirmée.');
        } else {
            $this->addFlash('danger', 'Code de livraison invalide');
        }


        return $this->redirectToRoute('livreur_dashboard');
    }
}
