<?php

namespace App\Repository;

use App\Entity\Product\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

 //   /**
 //    * @return Product[] Returns an array of Product objects
 //    */
    /*
    public function findFullProduct($id, $name)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p FROM App\Entity\Product\Product p
        WHERE p.id = :id AND p.id = (SELECT s FROM App\Entity\Product\Size s WHERE s.Name = :Name)
        ORDER BY p.id ASC'
        )->setParameter('id', $id)->setParameter('Name', $name);

        // returns an array of Product objects
        return $query->execute();
    }
*/

    /*
    public function findOneBySomeField($value): ?Product
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
