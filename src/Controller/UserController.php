<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
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

        return $this->render('user/index.html.twig');

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }


    /**
     * @Route("/user", name="user_index")
     */
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }



    /**
     * @Route("/remove_user/{id}", name="user_show")
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
}
