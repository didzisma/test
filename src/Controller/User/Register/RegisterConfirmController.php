<?php

declare(strict_types=1);

namespace App\Controller\User\Register;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterConfirmController
 * @package App\Controller\User\Register
 */
class RegisterConfirmController extends AbstractController
{
    /**
     * @Route("/user/confirm/{code}", name="user_register_confirm")
     *
     * @param UserRepository $userRepository
     * @param string $code
     *
     * @return RedirectResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(
        UserRepository $userRepository,
        string $code
    ): RedirectResponse
    {
        /** @var User $user */
        $user = $userRepository->findOneByConfirmationCode($code);

        if ($user) {
            $user->setIsActive(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_login');
    }
}
