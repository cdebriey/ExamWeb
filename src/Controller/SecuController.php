<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecuController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/signup", name="secu_signup")
     */
    public function formUser(User $user = null, Request $request, ManagerRegistry $manager) {

        $user = new User();
 
        $formUser = $this->createForm(RegistrationType::class, $user);
 
        $formUser->handleRequest($request);
 
        if($formUser->isSubmitted() && $formUser->isValid()) {
 
            $manager->getManager()->persist($user);
            $manager->getManager()->flush();
            
            return $this->redirectToRoute('car');
        }
 
        return $this->render('Security/signup.html.twig',[
            'formUser' => $formUser->createView()
        ]);
    }
}
