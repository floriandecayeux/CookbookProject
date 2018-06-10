<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recette", inversedBy="commentaires")
     * @ORM\JoinColumn(name="recette_id", referencedColumnName="id")
     */
    private $recette;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $commentaire;



    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCommentaire(): ?int
    {
        return $this->commentaire;
    }

    public function setCommentaire(int $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getRecette(){
        return $this->recette;
    }

    /**
     * @param mixed $recette
     */
    public function setRecette($recette)
    {
        $this->recette = $recette;
    }

}
