<?php

namespace App\Repository;

use App\Entity\VariationValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VariationValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method VariationValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method VariationValue[]    findAll()
 * @method VariationValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariationValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VariationValue::class);
    }

    // /**
    //  * @return VariationValue[] Returns an array of VariationValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VariationValue
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
