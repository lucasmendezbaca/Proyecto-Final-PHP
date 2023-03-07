<?php

namespace App\Repository;

use App\Entity\LineaFactura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LineaFactura>
 *
 * @method LineaFactura|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineaFactura|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineaFactura[]    findAll()
 * @method LineaFactura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineaFacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineaFactura::class);
    }

    public function save(LineaFactura $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LineaFactura $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // obtener un array con todos los totales de las lineas de factura
    public function getTotalLineasFacturas(): array
    {
        $totalLineasFactura = [];
        $lineasFactura = $this->findAll();
        foreach ($lineasFactura as $lineaFactura) {
            $total = $lineaFactura->getTotal();
            $totalLineasFactura[$lineaFactura->getId()] = $total;
        }

        return $totalLineasFactura;
    }

    // obtener el total de la linea de factura
    public function getTotalLineaFactura(LineaFactura $lineaFactura): float
    {
        $total = $lineaFactura->getTotal();

        return $total;
    }

//    /**
//     * @return LineaFactura[] Returns an array of LineaFactura objects
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

//    public function findOneBySomeField($value): ?LineaFactura
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
