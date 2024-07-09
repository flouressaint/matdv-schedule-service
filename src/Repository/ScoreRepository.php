<?php

namespace App\Repository;

use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Score>
 *
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository
{
    use RepositoryModifyTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    public function getScoreByStudentAndLesson(int $studentId, int $lessonId): ?Score
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.student = :studentId')
            ->andWhere('s.lesson = :lessonId')
            ->setParameter('studentId', $studentId)
            ->setParameter('lessonId', $lessonId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getScoresByLesson(int $lessonId): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.lesson = :lessonId')
            ->setParameter('lessonId', $lessonId)
            ->getQuery()
            ->getResult();
    }

    public function getScoresForStudent(int $studentId): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.student = :studentId')
            ->setParameter('studentId', $studentId)
            ->getQuery()
            ->getResult();
    }

    // public function setScoretoStudent()
    //    /**
    //     * @return Score[] Returns an array of Score objects
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

    //    public function findOneBySomeField($value): ?Score
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
