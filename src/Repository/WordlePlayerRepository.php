<?php

namespace App\Repository;

use App\Entity\WordlePlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WordlePlayer>
 *
 * @method WordlePlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordlePlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordlePlayer[]    findAll()
 * @method WordlePlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordlePlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordlePlayer::class);
    }

//    /**
//     * @return WordlePlayer[] Returns an array of WordlePlayer objects
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

//    public function findOneBySomeField($value): ?WordlePlayer
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
