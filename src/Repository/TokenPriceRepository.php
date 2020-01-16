<?php

namespace App\Repository;

use App\Entity\TokenPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TokenPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method TokenPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method TokenPrice[]    findAll()
 * @method TokenPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TokenPrice::class);
    }

    // /**
    //  * @return TokenPrice[] Returns an array of TokenPrice objects
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
    public function findOneBySomeField($value): ?TokenPrice
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
