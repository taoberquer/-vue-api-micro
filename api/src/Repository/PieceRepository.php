<?php

namespace App\Repository;

use App\Entity\Piece;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Piece|null find($id, $lockMode = null, $lockVersion = null)
 * @method Piece|null findOneBy(array $criteria, array $orderBy = null)
 * @method Piece[]    findAll()
 * @method Piece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PieceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Piece::class);
    }

    public function areAvailables(array $ids): bool
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('COUNT(p.id)')
            ->where('p.id IN (:ids)')
            ->andWhere('p.sold = 0')
            ->setParameter('ids', $ids);
        $count = $qb->getQuery()->getSingleScalarResult();

        return $count === count($ids);
    }

    public function setSoldPieces(array $ids): void
    {
        $qb = $this->createQueryBuilder('o');
        $qb->update('App\Entity\Piece', 'o')
            ->set('o.sold', ':sold')
            ->where('o.id IN (:ids)')
            ->setParameter('sold', 1)
            ->setParameter('ids', $ids);
        $qb->getQuery()->execute();
    }

    // /**
    //  * @return Piece[] Returns an array of Piece objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Piece
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
