<?php

declare(strict_types=1);

namespace App\Controller\User\Register\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CheckEmailController
 * @package App\Controller\User\Register\Api
 */
class CheckEmailController extends AbstractController
{
    /**
     * @Route("/user/register/email/check/{email}", name="user_register_email_check")
     *
     * @param Request $request,
     * @param UserRepository $userRepository
     * @param string $email
     *
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        string $email
    ): Response
    {
        if ($request->isXmlHttpRequest()) {
            $user = $userRepository->findOneByEmail($email);

            return $this->render('user/registration/api/email_check.html.twig', [
                'isValid' => (!$user instanceof User),
            ]);
        }

        return $this->redirectToRoute('homepage');
    }
}
