<?php

namespace App\Repository;

use App\Entity\TypeSuivi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeSuivi|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeSuivi|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeSuivi[]    findAll()
 * @method TypeSuivi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeSuiviRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeSuivi::class);
    }

    // /**
    //  * @return TypeSuivi[] Returns an array of TypeSuivi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeSuivi
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
