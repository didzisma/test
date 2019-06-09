<?php

declare(strict_types=1);

namespace App\Controller\User\Login;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 * @package App\Controller\User\Login
 */
class LoginController extends AbstractController
{
    /**
     * @Route("/user/login", name="user_login")
     *
     * @param Request             $request
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     * @throws \Exception
     */
    public function login(
        Request $request,
        AuthenticationUtils $authenticationUtils
    ): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }
}
