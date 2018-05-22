<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass="App\Repository\RecetteRepository")
 */
class Recette 
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $tempsPreparation;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPersonnes;


    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recettes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
  
   
    public function __construct(){

        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }


    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

   
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->titre,
            $this->nbPersonne,
            $this->tempsPreparation,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->titre,
            $this->nbPersonne,
            $this->tempsPreparation,

            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

  
}
