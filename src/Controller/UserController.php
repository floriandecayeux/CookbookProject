<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    /**
     * @Route("/user_login", name="user_login")
     */
    public function indexLogin(){
        return $this->render('user/index.html.twig', array(
            'action' => 'login'
        ));
    }

    /**
     * @Route("/user_register", name="user_register")
     */
    public function indexRegister(){
        return $this->render('user/index.html.twig', array(
            'action' => 'register'
        ));
    }

    /**
     * @Route("/user/indexcr", name="user")
     */
    public function createUser(UserPasswordEncoderInterface $encoder, $username, $mail, $password)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($mail);
       
        $plainPassword = $password;
        $encoded = $encoder->encodePassword($user, $plainPassword);

        $user->setPassword($encoded);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return $this->render('Saved new user with id '.$user->getId());
    }

    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function showAction($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('user/index.html.twig', array(
            'user' => $user
        ));

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/remove_user/{id}", name="user_delete")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $em->remove($user);
        $em->flush();

        if (!$user) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response("deleted");

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }


    /**
     * @Route("/user_new", name="user_new")
     */
    public function newUserAction(Request $request){
        //submit
            try{
                $username =  $request->request->get('_username');
                $password = $request->request->get('_password');
                $mail = $request->request->get('_mail');

                $user = new User();
                $user->setUsername($username);
                $user->setPassword($password);
                $user->setEmail($mail);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('user_login');
            } catch (\Exception $e) {
                return $this->render(
                    'user/index.html.twig',
                    array(
                        // last username entered by the user
                        'action' => 'register',
                        'error'  => true
                    )
                );
            }
    }

    /*
     public function newUserAction(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $user = new User();
       
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
       

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('index', array('id' => $user->getId()));
            } catch(\Doctrine\ORM\ORMException $e){
                return $this->render('user/index.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView()
                ));
            }
        }

         return $this->render('user/index.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        )); 
    }*/


}
