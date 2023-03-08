<?php

namespace App\Repository;

use App\Entity\Factura;
use App\Entity\LineaFactura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Factura>
 *
 * @method Factura|null find($id, $lockMode = null, $lockVersion = null)
 * @method Factura|null findOneBy(array $criteria, array $orderBy = null)
 * @method Factura[]    findAll()
 * @method Factura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factura::class);
    }

    public function save(Factura $entity, LineaFactura $lineaFactura, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Factura $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTotalFacturas(): array
    {
        $totalFacturas = [];
        $facturas = $this->findAll();
        foreach ($facturas as $factura) {
            $total = 0;
            foreach ($factura->getLineaFacturas() as $lineaFactura) {
                $total += $lineaFactura->getTotal();
            }
            $totalFacturas[$factura->getId()] = $total;
        }

        return $totalFacturas;
    }

    public function getTotalFactura(Factura $factura): float
    {
        $total = 0;
        foreach ($factura->getLineaFacturas() as $lineaFactura) {
            $total += $lineaFactura->getTotal();
        }

        return $total;
    }

    public function getLineasFactura(Factura $factura): array
    {
        $lineasFactura = [];
        foreach ($factura->getLineaFacturas() as $lineaFactura) {
            $lineasFactura[] = $lineaFactura;
        }

        return $lineasFactura;
    }

    public function getFacturasByEstado(string $estado): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT f
            FROM App\Entity\Factura f
            JOIN f.estado e
            WHERE e.nombre = :estado'
        )->setParameter('estado', $estado);

        return $query->getResult();
    }

    public function getFacturasByCliente(string $cliente): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT f
            FROM App\Entity\Factura f
            JOIN f.cliente c
            WHERE c.nombre = :cliente'
        )->setParameter('cliente', $cliente);

        return $query->getResult();
    }

    // filtrar las facturas para obtener las facturas que esten entre un importe minimo y maximo, el imoprte no esta en la tabla factura, sino que hay que sacarlo de multiplicando el precio de los productos de cada linea de factura por la cantidad de cada producto, las tablas factura y linea_factura estan relacionadas por el campo factura_id
    public function getFacturasByImporte(float $importeMinimo, float $importeMaximo): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT f
            FROM App\Entity\Factura f
            JOIN f.lineaFacturas lf
            JOIN lf.producto p
            GROUP BY f.id
            HAVING SUM(p.precio * lf.cantidad) BETWEEN :importeMinimo AND :importeMaximo'
        )->setParameter('importeMinimo', $importeMinimo)
        ->setParameter('importeMaximo', $importeMaximo);

        return $query->getResult();
    }


//    /**
//     * @return Factura[] Returns an array of Factura objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Factura
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
