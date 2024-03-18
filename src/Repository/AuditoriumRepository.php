<?php

namespace App\Repository;

use App\Entity\Auditorium;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auditorium>
 *
 * @method Auditorium|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auditorium|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auditorium[]    findAll()
 * @method Auditorium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditoriumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auditorium::class);
    }

//    /**
//     * @return Auditorium[] Returns an array of Auditorium objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Auditorium
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
