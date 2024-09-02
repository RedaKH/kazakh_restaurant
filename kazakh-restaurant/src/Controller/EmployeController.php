<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
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

    #[Route('/employe/new', name: 'add_employe')]
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
}
