<?php
/**
 * Created by PhpStorm.
 * User: clementvacandard
 * Date: 10/05/2018
 * Time: 17:38
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Recette;
use App\Form\RecetteType;
use App\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(){


        $em = $this->getDoctrine()->getManager();
         $topDesserts = $em->getRepository(Recette::class)->findAllDesserts();

         $topPlats = $em->getRepository(Recette::class)->findAllPlats();



         $topEntrees = $em->getRepository(Recette::class)->findAllEntrees();

        // Trie et affiche le tableau résultant
        uasort($topEntrees, array($this,"cmp"));





         return $this->render('index.html.twig', array(
            'topDesserts' => $topDesserts,
            'topPlats' => $topPlats,
            'topEntrees' => $topEntrees,
             'action' => 'top_recettes'
        ));



    }

 function cmp($recetteA, $recetteB){

          if ($recetteA->getNoteMoyenne() == $recetteB->getNoteMoyenne()) {
        return 0;
    }
    return ($recetteA->getNoteMoyenne() < $recetteB->getNoteMoyenne()) ? -1 : 1;
}

    /**
     * @Route("/search", name="search")
     */
    public function search(){

        return $this->render('index.html.twig', array(
            'action' => 'top_internautes'
        ));
    }




}