<?php

namespace App\Repository;

use App\Entity\StudyGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudyGroup>
 *
 * @method StudyGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudyGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudyGroup[]    findAll()
 * @method StudyGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudyGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudyGroup::class);
    }

//    /**
//     * @return StudyGroup[] Returns an array of StudyGroup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StudyGroup
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
