<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;
use App\Form\RegisterType;
use DateTime;

/* importo el formulario */


class UserController extends AbstractController
{
   /* metodo para hacer el registro de usuario */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
       /* crear formulario */
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        /* vincular el formulario con el objeto */
        $form->handleRequest($request);

        /* compruebo si el formulario ha sido enviado */
        if($form->isSubmitted() && $form->isValid()){
            /* recogo la informacion y la asigno a mi tabla users de la base de datos */
            $user->setRole('ROLE_USER');
            $user->setCreatedAt(new DateTime('now'));

            /* cifrar contraseña */
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            /* guardar usuario en base de datos */
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            /* despues de que me guarde en base de datos, que me redigira */
            return $this->redirectToRoute('tasks');


        }


        return $this->render('user/register.html.twig', [
           'form'=> $form->createView()
        ]);
    }



    /* metodo para hacer login */
    public function login(AuthenticationUtils $authenticationUtils){

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'error'=> $error,
            'last_username'=> $lastUsername
         ]);

    }
}
