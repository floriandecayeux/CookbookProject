<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Ingredient;

class IngredientController extends Controller
{
    /**
     * @Route("/ingredient", name="ingredient")
     */
    public function index()
    {
        return $this->render('ingredient/index.html.twig', [
            'controller_name' => 'IngredientController',
        ]);
    }
}
