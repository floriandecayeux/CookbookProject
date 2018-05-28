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
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $categorie;

     /**
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private $keyword;


    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recettes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
  
    public function getUser(){
        return $this->user;
    }
   
    public function __construct($user){
        $this->user = $user;
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
            $this->categorie,
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
            $this->categorie,

            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }


    public function  setTitre($titre): void{
        $this->titre = $titre;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function  setTempsPreparation($tempsPreparation): void{
        $this->tempsPreparation = $tempsPreparation;
    }

    public function getTempsPreparation()
    {
        return $this->tempsPreparation;
    }
    
    public function  setNbPersonnes($nbPersonnes): void{
        $this->nbPersonnes = $nbPersonnes;
    }

    public function getNbPersonnes()
    {
        return $this->nbPersonnes;
    }

     public function  setCategorie($categorie): void{
        $this->categorie = $categorie;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function  addKeyword($keyword){
         
        if(count(explode(";", $this->keyword)) <=4){

            $this->keyword =  $this->keyword . ";" . $keyword;

            return true;
        }
        else{
            return false;
        }


    }

     public function  deleteKeyword($position): void{
        $this->titre = $titre;
    }

     public function  clearKeyword(): void{
        $this->titre = $titre;
    }

//retourne sous forme de tableau la liste de mots clés
    public function getKeyword()
    {
        $keyList  = explode(";", $this->keyword);

        return $keyList;
    }

  
}
