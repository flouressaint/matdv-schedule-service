<?php

namespace App\Repository;

use App\Entity\Lesson;
use App\Exception\LessonNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lesson>
 *
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    use RepositoryModifyTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    public function getLessonsByDateAndTime(\DateTimeImmutable $date, \DateTimeImmutable $startTime, \DateTimeImmutable $endTime): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.date = :date')
            ->andWhere('l.startTime BETWEEN :startTime AND :endTime OR l.endTime BETWEEN :startTime AND :endTime')
            ->setParameter('date', $date)
            ->setParameter('startTime', $startTime)
            ->setParameter('endTime', $endTime)
            ->orderBy('l.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllSortedByDateAndTime(): array
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.date', 'ASC')
            ->orderBy('l.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getLessonById(int $id): ?Lesson
    {
        $lesson = $this->find($id);
        if (null === $lesson) {
            throw new LessonNotFoundException();
        }

        return $lesson;
    }

    public function getLessonsForStudyGroup(int $studyGroupId): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.studyGroup = :studyGroupId')
            ->setParameter('studyGroupId', $studyGroupId)
            ->orderBy('l.startTime', 'ASC')
            ->orderBy('l.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return Lesson[] Returns an array of Lesson objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Lesson
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
