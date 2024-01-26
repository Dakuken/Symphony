<?php

namespace App\Repository;

use App\Entity\WordleDictionary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WordleDictionary>
 *
 * @method WordleDictionary|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordleDictionary|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordleDictionary[]    findAll()
 * @method WordleDictionary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordleDictionaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordleDictionary::class);
    }

    public function findByWord($word)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.word = :val')
            ->setParameter('val', $word)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
