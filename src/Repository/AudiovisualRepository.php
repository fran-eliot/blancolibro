<?php

namespace App\Repository;

use App\Entity\Audiovisual;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Audiovisual>
 *
 * @method Audiovisual|null find($id, $lockMode = null, $lockVersion = null)
 * @method Audiovisual|null findOneBy(array $criteria, array $orderBy = null)
 * @method Audiovisual[]    findAll()
 * @method Audiovisual[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AudiovisualRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Audiovisual::class);
    }

//    /**
//     * @return Audiovisual[] Returns an array of Audiovisual objects
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

//    public function findOneBySomeField($value): ?Audiovisual
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
