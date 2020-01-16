<?php

namespace App\Repository;

use App\Entity\UserOrderDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserOrderDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserOrderDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserOrderDetail[]    findAll()
 * @method UserOrderDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserOrderDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserOrderDetail::class);
    }

    // /**
    //  * @return UserOrderDetail[] Returns an array of UserOrderDetail objects
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
    public function findOneBySomeField($value): ?UserOrderDetail
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
