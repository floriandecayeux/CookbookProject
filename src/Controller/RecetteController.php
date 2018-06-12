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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\User;
use App\Entity\Recette;
use App\Entity\Ingredient;
use App\Form\RecetteType;
use App\ImageUpload;
use App\EventListener\ImageUploadListener;



class RecetteController extends Controller
{

//affiche l'ensemble des recettes sur la page
    /**
     * @Route("/recettes", name="recettes")
     */
    public function index(Request $request){

        $em = $this->getDoctrine()->getManager();
        $post = $request->request->all();

        /*
        $order="date";
        if(isset($post['order'])) $order = $post['order'];
        */ 
        /*
        $titre_substring="";
        if(isset($post['titre_substring'])) $titre_substring = $post['titre_substring'];

        $auteur_substring="";
        if(isset($post['auteur_substring'])) $auteur_substring = $post['auteur_substring'];
        */

        $recettes = $em->getRepository(Recette::class)->findAll();




        return $this->render('index.html.twig', array(
            'recettes' => $recettes)/*, [
           

        ]*/);
    }
    /**
     * @Route("/recette_edit/{id}", name="recette_edit")
     */
    public function editAction($id){
        $recette = $this->getDoctrine()
            ->getRepository(Recette::class)
            ->find($id);

        return $this->render('recette/edit.html.twig', array(
            'recette' => $recette
        ));
    }

   /**
     * @Route("/recette_show/{id}", name="recette_show")
     */
    public function showAction($id)
    {
        $recette = $this->getDoctrine()
            ->getRepository(Recette::class)
            ->find($id);

        return $this->render('recette/show.html.twig', array(
            'recette' => $recette
        ));

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }



//permet la création d'une recette
    /**
     * @Route("/new_recette", name="new_recette")
     */
    public function newRecette(Request $request){


 // creates a task and gives it some dummy data for this example
     
         $recette = new Recette($this->getUser());

        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
       

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recette);
            $em->flush();

            return $this->redirectToRoute('mes_recettes');
        }

         return $this->render('recette/index.html.twig', array(
            'recette' => $recette,
            'form' => $form->createView(),
        )); 
      

    }

//liste l'ensemble des recettes de l'utilisateur
    /**
     * @Route("/mes_recettes", name="mes_recettes")
     */
    public function mesRecette(Request $request){


        $user= $this->getUser();

        $recettes = $user->getRecettes();

         return $this->render('recette/mes_recettes.html.twig', array(
            'recettes' => $recettes,
             'action' => 'recettes'
        )); 
    }

    /**
     * @Route("/mes_recettes_new", name="mes_recettes_new")
     */
    public function mesRecetteNew(Request $request){


        $user= $this->getUser();

        $recettes = $user->getRecettes();

        return $this->render('recette/mes_recettes.html.twig', array(
            'recettes' => $recettes,
            'action' => 'recettes_new'
        ));
    }



    /**
     * @Route("/ajout_recette", name="ajout_recette")
     */
    public function ajoutRecette(Request $request){

    //submit
        try{
            $em = $this->getDoctrine()->getManager();

           $titre = $request->request->get('_titre');
           $categorie = $request->request->get('_categorie');
           $nbPersonnes = $request->request->get('_nbPersonnes');
           $tempsPreparation= $request->request->get('_tempsPrepa');
           $ingredients = $request->request->get('ingredients');
           $etapes = $request->request->get('_etapes');
           $file = $request->files->get('new_recette');

            $recette = new Recette($this->getUser());
            $recette->setTitre($titre);
            $recette->setCategorie($categorie);
            $recette->setNbPersonnes($nbPersonnes);
            $recette->setTempsPreparation($tempsPreparation);
            $recette->setImage($file['image']);
            $recette->setEtapes($etapes);

            $upload = new ImageUpload('../public/uploads/images');
            $ImageUploadListener = new ImageUploadListener($upload);
            $ImageUploadListener->uploadFile($recette);

            $em->persist($recette);
            $em->flush();

            foreach($ingredients as $ingredientElem){
                $ingredient = new Ingredient();
                $ingredient->setNom($ingredientElem[0]);
                $ingredient->setQuantite($ingredientElem[1]);
                $ingredient->setUnite($ingredientElem[2]);
                $ingredient->setRecette($recette);
                $em->persist($ingredient);
                $em->flush();

            }
            return $this->redirectToRoute('mes_recettes');

        } catch (\Exception $e) {
            return $this->render(
                'recette/mes_recettes.html.twig',
                array(
                    // last username entered by the user
                    'action' => 'recettes_new',
                    'error'  => true,
                    'message' => $e->getMessage(),
                    'request' => $request
                )
            );
        }
    }


    /**
     * @Route("/modif_recette/{id}", name="modif_recette")
     */
    public function modifRecette(Request $request, $id){
        try{
            $em = $this->getDoctrine()->getManager();

            $titre = $request->request->get('_titre');
            $categorie = $request->request->get('_categorie');
            $nbPersonnes = $request->request->get('_nbPersonnes');
            $tempsPreparation= $request->request->get('_tempsPrepa');
            $ingredients = $request->request->get('ingredients');
            $etapes = $request->request->get('_etapes');

            $recette = $this->getDoctrine()
                ->getRepository(Recette::class)
                ->find($id);

            $recette->setTitre($titre);
            $recette->setCategorie($categorie);
            $recette->setNbPersonnes($nbPersonnes);
            $recette->setTempsPreparation($tempsPreparation);
            $recette->setEtapes($etapes);

            $em->persist($recette);
            $em->flush();

            foreach ($recette->getIngredients() as $ingredientRecette){
                $em->remove($ingredientRecette);
                $em->flush();
            }

            foreach($ingredients as $ingredientElem){
                $ingredient = new Ingredient();
                $ingredient->setNom($ingredientElem[0]);
                $ingredient->setQuantite($ingredientElem[1]);
                $ingredient->setUnite($ingredientElem[2]);
                $ingredient->setRecette($recette);
                $em->persist($ingredient);
                $em->flush();
            }

            return $this->redirectToRoute('recette_show', array(
                'id' => $id
            ));

        } catch (\Exception $e) {
            return $this->redirectToRoute('recette_edit', array(
                'id' => $id
            ));
        }
    }





}

