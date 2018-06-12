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
         $topDesserts = $em->getRepository(Recette::class)->findTopDessert();
         $topPlats = $em->getRepository(Recette::class)->findTopPlats();
         $topEntrees = $em->getRepository(Recette::class)->findTopEntrees();
         return $this->render('index.html.twig', array(
            'topDesserts' => $topDesserts,
            'topPlats' => $topPlats,
            'topEntrees' => $topEntrees
        ));



    }






}