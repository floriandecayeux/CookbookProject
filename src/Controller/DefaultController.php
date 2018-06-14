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

           // Trie et affiche le tableau résultant
        uasort($topPlats, array($this,"cmp"));

           // Trie et affiche le tableau résultant
        uasort($topDesserts, array($this,"cmp"));





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
        return ($recetteA->getNoteMoyenne() > $recetteB->getNoteMoyenne()) ? -1 : 1;
    }
    /**
     * @Route("/top_user", name="top_user")
     */
    public function topUser(){
        $em = $this->getDoctrine()->getManager();
        $topUser = $em->getRepository(User::class)->findAll();
        uasort($topUser, array($this,"triUser"));

        return $this->render('index.html.twig', array(
            'topUsers' => $topUser,
            'action' => 'top_internautes'
        ));
    }



 function triUser($userA, $userB){

        if ($userA->getNoteMoyenne() == $userB->getNoteMoyenne()) {
        return 0;
    }
    return ($userA->getNoteMoyenne() > $userB->getNoteMoyenne()) ? -1 : 1;
}

  /**
     * @Route("/search", name="search")
     */
    public function search(Request $request){

        try{
            $em = $this->getDoctrine()->getManager();
            $titre = $request->request->get('_titre');
            $categorie = $request->request->get('_categorie');
            $pays = $request->request->get('_pays');

            $recettes = $em->getRepository(Recette::class)->search($titre, $categorie, $pays);
        } catch (\Exception $e) {
            return $this->render(
                'search.html.twig',
                array(
                    // last username entered by the user
                    'action' => 'recettes',
                    'error'  => true,
                    'message' => $e->getMessage(),
                    'request' => $request
                )
            );
        }

        return $this->render('search.html.twig', array(
            'recettes' => $recettes,
            'stitre' => $titre,
            'scategorie' => $categorie,
            'spays' => $pays,
            'action' => 'recettes'
        ));
    }

    /**
     * @Route("/search_int", name="search_int")
     */
    public function searchInt(Request $request){

        try{
            $em = $this->getDoctrine()->getManager();
            $username = $request->request->get('_username');
            $users = $em->getRepository(User::class)->search($username);

        } catch (\Exception $e) {
            return $this->render(
                'search.html.twig',
                array(
                    // last username entered by the user
                    'action' => 'internautes',
                    'error'  => true,
                    'message' => $e->getMessage(),
                    'request' => $request
                )
            );
        }

        return $this->render('search.html.twig', array(
            'users' => $users,
            'susername' => $username,
            'action' => 'internautes'
        ));
    }





}