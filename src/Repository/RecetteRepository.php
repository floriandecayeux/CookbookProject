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

   


      public function findAllDesserts()
    {
      
     return $this->createQueryBuilder('r')
                    ->where("r.categorie = 'dessert' ")
                    ->getQuery()
                    ->getResult();

  
    }

        public function findAllEntrees()
    {
      
     return $this->createQueryBuilder('r')
                    ->where("r.categorie = 'entree' ")
                    ->getQuery()
                    ->getResult();

  
    }
  
  
      public function findAllPlats()
    {
      
     return $this->createQueryBuilder('r')
                    ->where("r.categorie = 'plat' ")
                    ->getQuery()
                    ->getResult();

  
    }
 
    public function  search($titre, $categorie, $pays) {

       return $this->createQueryBuilder('r')
                    ->where("r.titre like ?1")
                    ->andWhere("r.categorie like ?2")
                    ->andWhere("r.pays like ?3")->setParameter(1, $titre)
                    ->setParameter(2, $categorie)
                    ->setParameter(3, $pays)
                    ->getQuery()
                    ->getResult();
      
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
