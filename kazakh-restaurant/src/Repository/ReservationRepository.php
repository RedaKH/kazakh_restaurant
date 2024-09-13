<?php

namespace App\Repository;

use App\Entity\Employe;
use App\Entity\Reservation;
use App\Enum\ReservationType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    //    /**
    //     * @return Reservation[] Returns an array of Reservation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reservation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function canReserveOnDate(\DateTimeImmutable $date): bool
    {
        $startOfDay = $date->setTime(0, 0, 0);
        $endOfDay = $date->setTime(23, 59, 59);

        $query = $this->createQueryBuilder('r')
            ->andWhere('r.DateReservation >= :startOfDay')
            ->andWhere('r.DateReservation < :endOfDay')
            ->andWhere('r.ReservationType = :type')
            ->setParameter('startOfDay', $startOfDay)
            ->setParameter('endOfDay', $endOfDay)
            ->setParameter('type', ReservationType::PRIVATISATION->value)
            ->getQuery();

        $result = $query->getOneOrNullResult();

        return $result === null;
    }


    public function searchDelivery(Employe $livreur, string $term):array
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.client', 'c')
            ->andWhere('r.livreur = :livreur')
            ->andWhere('c.nom LIKE :term or c.prenom Like :term OR r.plat LIKE :term')
            ->setParameter('livreur', $livreur)
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getResult();
    }

    public function searchReservationsForAssignment(string $term): array
{
    return $this->createQueryBuilder('r')
        ->innerJoin('r.client', 'c')
        ->andWhere('r.livreur IS NULL')
        ->andWhere('r.ReservationType = :type')
        ->andWhere('(c.nom LIKE :term OR c.prenom LIKE :term OR r.plat LIKE :term)')
        ->setParameter('type', ReservationType::LIVRAISON)
        ->setParameter('term', '%' . $term . '%')
        ->getQuery()
        ->getResult();
}

public function searchReservationsForEmploye(Employe $employe, string $term): array
{
    return $this->createQueryBuilder('r')
        ->innerJoin('r.client', 'c')
        ->andWhere('c.nom LIKE :term OR c.prenom LIKE :term OR r.plat LIKE :term')
        ->setParameter('term', '%' . $term . '%')
        ->getQuery()
        ->getResult();
}


}
