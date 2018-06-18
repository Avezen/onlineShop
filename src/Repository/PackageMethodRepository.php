<?php

namespace App\Repository;

use App\Entity\Order\PackageMethod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PackageMethod|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackageMethod|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackageMethod[]    findAll()
 * @method PackageMethod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageMethodRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PackageMethod::class);
    }

//    /**
//     * @return PackageMethod[] Returns an array of PackageMethod objects
//     */
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
    public function findOneBySomeField($value): ?PackageMethod
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
