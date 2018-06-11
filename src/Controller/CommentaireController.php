<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Commentaire;
use App\Entity\Recette;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
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

    /**
     * @Route("/ajout_commentaire/{id}", name="ajout_commentaire")
     */
    public function addAction(Request $request, $id){
        try{
            $em = $this->getDoctrine()->getManager();
            $recette = $this->getDoctrine()
                ->getRepository(Recette::class)
                ->find($id);

            $comment = $request->request->get('_comment');

            $commentaire = new Commentaire();
            $commentaire->setUser($this->getUser());
            $commentaire->setCommentaire($comment);
            $commentaire->setRecette($recette);

            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('recette_show', array(
                'id' => $id
            ));

        } catch (\Exception $e) {
            return $this->redirectToRoute('recette_show', array(
                'id' => $id
            ));
        }

    }
}
