<?php

namespace App\Repository;

use App\Entity\Subapartado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subapartado>
 *
 * @method Subapartado|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subapartado|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subapartado[]    findAll()
 * @method Subapartado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubapartadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subapartado::class);
    }

//    /**
//     * @return Subapartado[] Returns an array of Subapartado objects
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

//    public function findOneBySomeField($value): ?Subapartado
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
