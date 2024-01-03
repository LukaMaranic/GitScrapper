<?php

namespace App\Controller;

use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/login_check', name: 'app_login_check')]
    public function loginCheck(Request $request): void
    {
        $x = "lala";
    }

//    #[Route('/login', name: 'app_login', methods: 'POST')]
//    public function login(AuthenticationUtils $authenticationUtils): Response
//    {
//        $error = $authenticationUtils->getLastAuthenticationError();
//
//        $lastUsername = $authenticationUtils->getLastUsername();
//        return $this->render('login/index.html.twig', [
//            'last_username' => $lastUsername,
//            'error'         => $error,
//        ]);
//    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(Security $security): Response
    {
        return $security->logout();
    }
}
