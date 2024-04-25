<?php

namespace App\Repository;

use App\Entity\Hometask;
use App\Exception\HometaskNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hometask>
 *
 * @method Hometask|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hometask|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hometask[]    findAll()
 * @method Hometask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HometaskRepository extends ServiceEntityRepository
{
    use RepositoryModifyTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hometask::class);
    }

    public function getHometaskById(int $id): ?Hometask
    {
        $hometask = $this->find($id);
        if (null === $hometask) {
            throw new HometaskNotFoundException();
        }

        return $hometask;
    }

    //    /**
    //     * @return Hometask[] Returns an array of Hometask objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Hometask
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}