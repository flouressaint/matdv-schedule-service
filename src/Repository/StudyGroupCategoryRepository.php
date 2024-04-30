<?php

namespace App\Repository;

use App\Entity\StudyGroupCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudyGroupCategory>
 *
 * @method StudyGroupCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudyGroupCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudyGroupCategory[]    findAll()
 * @method StudyGroupCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudyGroupCategoryRepository extends ServiceEntityRepository
{
    use RepositoryModifyTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudyGroupCategory::class);
    }

    //    /**
    //     * @return StudyGroupCategory[] Returns an array of StudyGroupCategory objects
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

    //    public function findOneBySomeField($value): ?StudyGroupCategory
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}