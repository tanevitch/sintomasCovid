<?php

namespace App\Repository;

use App\Entity\UserSintomas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserSintomas|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSintomas|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSintomas[]    findAll()
 * @method UserSintomas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSintomasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSintomas::class);
    }

    // /**
    //  * @return UserSintomas[] Returns an array of UserSintomas objects
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
    public function findOneBySomeField($value): ?UserSintomas
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
