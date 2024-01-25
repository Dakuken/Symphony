<?php

namespace App\Repository;

use App\Entity\WordleGuess;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WordleGuess>
 *
 * @method WordleGuess|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordleGuess|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordleGuess[]    findAll()
 * @method WordleGuess[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordleGuessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordleGuess::class);
    }

//    /**
//     * @return WordleGuess[] Returns an array of WordleGuess objects
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

//    public function findOneBySomeField($value): ?WordleGuess
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
