<?php

namespace App\Repository;

use App\Entity\PostTags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostTags|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostTags|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostTags[]    findAll()
 * @method PostTags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostTagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostTags::class);
    }

    // /**
    //  * @return PostTags[] Returns an array of PostTags objects
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
    public function findOneBySomeField($value): ?PostTags
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
