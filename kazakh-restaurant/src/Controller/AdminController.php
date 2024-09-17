<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Enum\ReservationType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/assigner-livraison', name: 'app_admin')]
    public function assignerLivraison(Request $request, ReservationRepository $reservationRepository, EmployeRepository $employeRepository): Response
    {
        // Trouve les réservations qui n'ont pas été attribuées et sont de type livraison
        $reservations = $reservationRepository->findBy([
            'livreur' => null,
            'ReservationType' => ReservationType::LIVRAISON
        ]);

        // Trouve les employés ayant le rôle de livreur
        $livreurs = $employeRepository->findByRole('ROLE_LIVREUR');

        if ($request->isMethod('POST')) {
            $reservationID = $request->request->get('reservation_id');
            $livreurID = $request->request->get('employe_id');

            $reservation = $reservationRepository->find($reservationID);
            $livreur = $employeRepository->find($livreurID);

            if ($reservation && $livreurID) {
                $reservation->setLivreur($livreur);

                $this->entityManager->flush(); 
                $this->addFlash('success', 'Livreur assigné avec succès');
                return $this->redirectToRoute('app_admin');
            } else {
                $this->addFlash('danger', 'Une erreur est survenue lors de l\'assignation.');
            }
        }

        return $this->render('admin/dashboard_livraison.html.twig', [
            'reservations' => $reservations,
            'livreurs' => $livreurs
        ]);
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

        return $this->render('admin/add_employe.html.twig', [
            'employe' => $employe,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/rechercher-assignation-livraison', name: 'rechercher_assignation_livraison', methods: ['GET', 'POST'])]
public function rechercherAssignationLivraison(Request $request, ReservationRepository $reservationRepository, EmployeRepository $employeRepository): Response
{
    $searchTerm = $request->query->get('search', '');
    $reservations = [];

    if ($searchTerm) {
        $reservations = $reservationRepository->searchReservationsForAssignment($searchTerm);
    } else {
        $reservations = $reservationRepository->findBy([
            'livreur' => null,
            'ReservationType' => ReservationType::LIVRAISON
        ]);
    }

    $livreurs = $employeRepository->findByRole('ROLE_LIVREUR');

    return $this->render('admin/dashboard_livraison.html.twig', [
        'reservations' => $reservations,
        'livreurs' => $livreurs,
    ]);
}

#[Route('/admin/employe/delete/{id}', name: 'employe_delete')]
public function delete_employe(Employe $employe): Response
{
    $this->entityManager->remove($employe);
    $this->entityManager->flush();

    return $this->redirectToRoute('employe_list');
}

#[Route(path: '/admin/employe-list', name: 'employe_list')]

public function EmployeList(EmployeRepository $employeRepository) : Response {
    $employes = $employeRepository->findAll();

    return $this->render('admin/list-employes.html.twig',[
        'employes'=>$employes
    ]);
    
}
#[Route(path: '/admin/employe/edit/{id}', name: 'employe_edit')]

public function editEmploye(Employe $employe,Request $request, UserPasswordHasherInterface $passwordhasher) : Response {
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

            $this->addFlash('success','Les informations de l\'employé ont bien été mise a jour');



            return $this->redirectToRoute('employe_list');
        }

        return $this->render('admin/add_employe.html.twig', [
            'employe' => $employe,
            'form' => $form->createView()
        ]);
    
}

    
    
}
