<?php

namespace App\Repository;

use App\Entity\WordleConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WordleConfiguration>
 *
 * @method WordleConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordleConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordleConfiguration[]    findAll()
 * @method WordleConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordleConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordleConfiguration::class);
    }

//    /**
//     * @return WordleConfiguration[] Returns an array of WordleConfiguration objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WordleConfiguration
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
