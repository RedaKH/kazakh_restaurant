<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

//    /**
//     * @return Client[] Returns an array of Client objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Client
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function validateCode(int $clientId, int $codecli): bool
{
    $qb = $this->createQueryBuilder('c')
    ->select('c.id')
    ->where('c.id = :clientId')
    ->andWhere('c.code_client = :codecli')
    ->andWhere('c.code_client IS NOT NULL')  // S'assure que code_client n'est pas null
    ->setParameter('clientId',$clientId)
    ->setParameter('codecli',$codecli)
    ->getQuery();

    //executer la requete pour voir si le  client et le code existe
    $result = $qb->getOneOrNullResult();

    return $result !==null;



}


}
