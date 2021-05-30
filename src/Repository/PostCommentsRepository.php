<?php

namespace App\Repository;

use App\Entity\PostComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostComments[]    findAll()
 * @method PostComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostCommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostComments::class);
    }

    // /**
    //  * @return PostComments[] Returns an array of PostComments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostComments
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
