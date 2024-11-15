<?php

namespace App\Repository;

use App\Entity\UserStep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserStep>
 *
 * @method UserStep|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserStep|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserStep[]    findAll()
 * @method UserStep[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserStepRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserStep::class);
    }

//    /**
//     * @return UserStep[] Returns an array of UserStep objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserStep
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
