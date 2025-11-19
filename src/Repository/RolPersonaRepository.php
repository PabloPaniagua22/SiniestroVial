<?php

namespace App\Repository;

use App\Entity\RolPersona;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RolPersona>
 */
class RolPersonaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RolPersona::class);
    }
    public function getCantidadPorRol(): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.nombre AS rol, COUNT(ds.id) AS cantidad')
            ->leftJoin('r.detalleSiniestros', 'ds')
            ->groupBy('r.id')
            ->getQuery()
            ->getArrayResult();
    }


    //    /**
    //     * @return RolPersona[] Returns an array of RolPersona objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RolPersona
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
