<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Ingredient;
use Doctrine\Common\Collections\ArrayCollection;



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
     * @ORM\Column(type="string", length=50)
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
     * @ORM\Column(type="string", length=25)
     */
    private $categorie;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $keyword;

    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recettes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ingredient", mappedBy="recette")
     */
    private $ingredients;


    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(message="Ajouter une image jpg")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image;


    /**
     * @ORM\Column(type="string", length=3000)
     */
    private $etapes;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="recette")
     */
    protected $commentaires;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="recette")
     */
    protected $notes;





    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }



  
    public function getUser(){
        return $this->user;
    }
   
    public function __construct($user){
        $this->user = $user;
        $this->commentaires = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
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
            $this->nbPersonnes,
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


    /**
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }


    /**
     * @return Collection|Recette[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }


     /**
     * @return Collection|Recette[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }


    /**
     * @return mixed
     */
    public function getEtapes()
    {
        return $this->etapes;
    }

    /**
     * @param mixed $etapes
     */
    public function setEtapes($etapes)
    {
        $this->etapes = $etapes;
    }
  
}
