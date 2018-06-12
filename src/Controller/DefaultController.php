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

    //get 50 top dessert pr moyenne des notes
        $query = $em->createQuery("SELECT r, AVG(note.note) as moyenne 
                                         FROM Recette r
                                         LEFT JOIN Note n ON r.id = n.recette_id
                                         WHERE r.categorie = 'dessert'
                                         GROUP BY r.id 
                                         ORDER BY moyenne DESC
                                         LIMIT 50
                                         ");
        $topDesserts = $query->getResult();

         return $this->render('index.html.twig', array(
            'topDesserts' => $topDesserts
        ));



    }






}