<?php

namespace App\Repository;

use App\Entity\StudyGroup;
use App\Exception\StudyGroupNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
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
    use RepositoryModifyTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudyGroup::class);
    }

    public function getStudyGroupById(int $id): StudyGroup
    {
        $studyGroup = $this->find($id);
        if (null === $studyGroup) {
            throw new StudyGroupNotFoundException();
        }

        return $studyGroup;
    }

    public function findAllSortedByName(): array
    {
        return $this->findBy([], ['name' => Criteria::ASC]);
    }

    public function findAllWithCategorySortedByCategory(): array
    {
        return $this->createQueryBuilder('sg')
            ->leftJoin('sg.studyGroupCategory', 'sc')
            ->orderBy('sc.name', 'ASC')
            ->addOrderBy('sg.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getStudyGroupsByCategoryId(int $categoryId): array
    {
        $studyGroups = $this->findBy(['studyGroupCategory' => $categoryId]);
        if (empty($studyGroups)) {
            throw new StudyGroupNotFoundException();
        }

        return $studyGroups;
    }

    public function existsByName(string $name): bool
    {
        return null !== $this->findOneBy(['name' => $name]);
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
