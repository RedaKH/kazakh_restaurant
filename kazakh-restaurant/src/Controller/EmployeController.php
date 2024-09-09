<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Entity\Reservation;
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

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        
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
            'form'=> $form->createView()
        ]);
    }

    #[Route('/employe/dashboard', name: 'employe_dashboard')]
    public function dashboard(): Response
    {
        $reservations = $this->entityManager->getRepository(Reservation::class)->findAll();

        return $this->render('blog/blogs.html.twig', [
            'reservations' => $reservations,
        ]);
        }

      /*  #[Route('/livreur/dashboard', name: 'livreur_dashboard')]

        public function verifyCodeLivraison(Request $request): Response
        {

        $codeLivraison = $request->request->get('code_livraison');
        $client = $this->entityManager->getRepository(Client::class)
        ->findOneBy(['code_cli'=>$codeLivraison]);

        if ($client) {
            //code valide
            $this->addFlash('success','Le code de livraison est valide');
            # code...
        } else {
            $this->addFlash('danger','Le code de livraison est invalide');


        }
        return $this->redirectToRoute('livreur_dashboard'); 


        } */

        


}
