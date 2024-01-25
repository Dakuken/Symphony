<?php

namespace App\Repository;

use App\Entity\WordleSolution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WordleSolution>
 *
 * @method WordleSolution|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordleSolution|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordleSolution[]    findAll()
 * @method WordleSolution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordleSolutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordleSolution::class);
    }

//    /**
//     * @return WordleSolution[] Returns an array of WordleSolution objects
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

//    public function findOneBySomeField($value): ?WordleSolution
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
