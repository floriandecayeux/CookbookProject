<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Recette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recette[]    findAll()
 * @method Recette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recette::class);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */

    public function findTopDessert()
    {
      
      $rawSql = "SELECT r.*, AVG(n.note) as moyenne 
                                         FROM Recette AS r
                                         LEFT JOIN Note AS n ON r.id = n.recette_id
                                         WHERE r.categorie = 'dessert'
                                         GROUP BY r.id 
                                         ORDER BY moyenne DESC
                                         LIMIT 50
                                         ";

      $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
      $stmt->execute([]);

    return $stmt->fetchAll();

  
    }

     public function findTopPlats()
    {
      
      $rawSql = "SELECT r.*, AVG(n.note) as moyenne 
                                         FROM Recette AS r
                                         LEFT JOIN Note AS n ON r.id = n.recette_id
                                         WHERE r.categorie = 'plat'
                                         GROUP BY r.id 
                                         ORDER BY moyenne DESC
                                         LIMIT 50
                                         ";

      $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
      $stmt->execute([]);

    return $stmt->fetchAll();

  
    }

     public function findTopEntrees()
    {
      
      $rawSql = "SELECT r.*, AVG(n.note) as moyenne 
                                         FROM Recette AS r
                                         LEFT JOIN Note AS n ON r.id = n.recette_id
                                         WHERE r.categorie = 'entree'
                                         GROUP BY r.id 
                                         ORDER BY moyenne DESC
                                         LIMIT 50
                                         ";

      $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
      $stmt->execute([]);

    return $stmt->fetchAll();

  
    }
  

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
