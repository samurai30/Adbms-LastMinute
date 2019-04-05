<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="SecuredLogin")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function studentLogin(AuthenticationUtils $authenticationUtils)
    {
        return $this->render('login/index.html.twig', [
            'lastname' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }




}
