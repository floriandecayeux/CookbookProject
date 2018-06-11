<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Note;
use App\Entity\Recette;
use Symfony\Component\HttpFoundation\Request;

class NoteController extends Controller
{
    /**
     * @Route("/note", name="note")
     */
    public function index()
    {
        return $this->render('ingredient/index.html.twig', [
            'controller_name' => 'IngredientController',
        ]);
    }

    /**
     * @Route("/ajout_note/{id}/{note}", name="ajout_note")
     */
    public function addAction($id, $note){
        try{
            $em = $this->getDoctrine()->getManager();
            $recette = $this->getDoctrine()
                ->getRepository(Recette::class)
                ->find($id);

            $new_note = new Note();
            $new_note->setUser($this->getUser());
            $new_note->setRecette($recette);
            $new_note->setNote($note);

            $em->persist($new_note);
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
