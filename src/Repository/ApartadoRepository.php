<?php

namespace App\Repository;

use App\Entity\Apartado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Apartado>
 *
 * @method Apartado|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apartado|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apartado[]    findAll()
 * @method Apartado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApartadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apartado::class);
    }

//    /**
//     * @return Apartado[] Returns an array of Apartado objects
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

//    public function findOneBySomeField($value): ?Apartado
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
