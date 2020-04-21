<?php

namespace App\Repository;

use App\Entity\Ordo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ordo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordo[]    findAll()
 * @method Ordo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordo::class);
    }

    // /**
    //  * @return Ordo[] Returns an array of Ordo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ordo
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
