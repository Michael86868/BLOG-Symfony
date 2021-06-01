<?php

namespace App\Repository;

use App\Entity\WeatherStation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WeatherStation|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeatherStation|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeatherStation[]    findAll()
 * @method WeatherStation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherStationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeatherStation::class);
    }

    // /**
    //  * @return WeatherStation[] Returns an array of WeatherStation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WeatherStation
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return WeatherStation|null
     * @throws NonUniqueResultException
     */
    public function findLastRecord(): ?WeatherStation
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneColumn($column)
    {
        return $this->createQueryBuilder('w')
            ->select('w.'.$column)
            ->orderBy('w.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
