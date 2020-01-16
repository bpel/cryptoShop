<?php

namespace App\Repository;

use App\Entity\UserOrderStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserOrderStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserOrderStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserOrderStatus[]    findAll()
 * @method UserOrderStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserOrderStatus::class);
    }

    // /**
    //  * @return UserOrderStatus[] Returns an array of UserOrderStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserOrderStatus
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
