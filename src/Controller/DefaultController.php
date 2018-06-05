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

        $recettes = $this->getDoctrine()
            ->getRepository(Recette::class)
            ->findAll();

       return $this->render('index.html.twig', array(
            'recettes' => $recettes)/*, [
            'reservations' => $reservations,
            'metresReserves' => $metresReserves,
            'sommeCollectee' => $sommeCollectee

        ]*/);
    }






}