<?php

namespace App\Repository;

use App\Entity\Siniestro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Siniestro>
 */
class SiniestroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Siniestro::class);
    }

    public function filtrarPorFechas($desde, $hasta)
    {
    $qb = $this->createQueryBuilder('s');

    if ($desde) {
        $qb->andWhere('s.fecha >= :desde')
           ->setParameter('desde', $desde);
    }

    if ($hasta) {
        $qb->andWhere('s.fecha <= :hasta')
           ->setParameter('hasta', $hasta);
    }

    return $qb->orderBy('s.fecha', 'DESC')->getQuery()->getResult();
    }

    public function getSiniestrosPorMes($desde = null, $hasta = null)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT MONTH(fecha) AS mes, COUNT(*) AS cantidad
            FROM siniestro
            WHERE (:desde IS NULL OR fecha >= :desde)
            AND (:hasta IS NULL OR fecha <= :hasta)
            GROUP BY MONTH(fecha)
            ORDER BY mes
        ";

        return $conn->executeQuery($sql, [
            'desde' => $desde,
            'hasta' => $hasta,
        ])->fetchAllAssociative();
    }


    //    /**
    //     * @return Siniestro[] Returns an array of Siniestro objects
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

    //    public function findOneBySomeField($value): ?Siniestro
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
