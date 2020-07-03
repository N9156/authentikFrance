<?php

namespace App\Repository;

use App\Entity\SiteTouristique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SiteTouristique|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteTouristique|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteTouristique[]    findAll()
 * @method SiteTouristique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteTouristiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteTouristique::class);
    }

    // /**
    //  * @return SiteTouristique[] Returns an array of SiteTouristique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SiteTouristique
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
