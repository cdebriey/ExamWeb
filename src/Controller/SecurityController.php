<?php

namespace App\Controller;

use App\Entity\User;;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ManagerRegistry $manager, UserPasswordHasherInterface $hasher){
        $user = new User();

        $formUser =$this->createForm(RegistrationType::class, $user);

        $formUser->handleRequest($request);

        if($formUser->isSubmitted() && $formUser->isValid()) {
            /*$hash = $hasher->hashPassword($user, $user->getPassword());

            $user->setPassword($hash);*/
            
            $manager->getManager()->persist($user);
            $manager->getManager()->flush();
            
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'formUser'=>$formUser->createView()
        ]);
    }

    /**
     * @Route ("/login", name="security_login")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }
}
