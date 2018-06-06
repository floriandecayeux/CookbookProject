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
     * @Route("/recette_show", name="recette_show")
     */
    public function showAction($recette)
    {
        
        

        return $this->render('recette/index.html.twig', array(
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

        $request = $this->get('request_stack')->getCurrentRequest();

        
    //submit
        try{
           $titre =  $request->request->get('_titre');
           $categorie = $request->request->get('_categorie');
           $nbPersonnes = $request->request->get('_nbPersonnes');
           $tempsPreparation= $request->request->get('_tempsPrepa');

            $recette = new Recette($this->getUser());
            $recette->setTitre($titre);
            $recette->setCategorie($categorie);
            $recette->setNbPersonnes($nbPersonnes); 
            $recette->setTempsPreparation($tempsPreparation); 

            $em = $this->getDoctrine()->getManager();
            $em->persist($recette);
            $em->flush();

            return $this->redirectToRoute('mes_recettes');

        } catch (\Exception $e) {
            return $this->render(
                'recette/mes_recettes.html.twig',
                array(
                    // last username entered by the user
                    'action' => 'recettes_new',
                    'error'  => true
                )
            );
        }
    }


    /**
     * @Route("/ajout_image", name="ajout_image")
     */
    public function ajoutImageRecette(Request $request){

        $request = $this->get('request_stack')->getCurrentRequest();

           $recette = $this->getDoctrine()
            ->getRepository(Recette::class)
            ->find(5);

       //submit
        try{

            $file = $request->files->get('new_recette');
            $recette->setImage($file['image']);

            $upload = new ImageUpload('../public/uploads/images');
            $ImageUploadListener = new ImageUploadListener($upload);
            $ImageUploadListener->uploadFile($recette);


            $em = $this->getDoctrine()->getManager();
            $em->persist($recette);
            $em->flush();


            return $this->render('recette/mes_recettes.html.twig');

        //   return $this->redirectToRoute('mes_recettes');

        } catch (\Exception $e) {
            return $this->render(
                'recette/image.html.twig',
                array(
                    // last username entered by the user
                    'action' => 'ajout_image',
                    'error'  => $e->getMessage(),

                )
            );
        }
   
    }





}

