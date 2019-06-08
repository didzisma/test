<?php

declare(strict_types=1);

namespace App\Controller\User\Register;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegisterController
 * @package App\Controller\Profile\Register
 */
class RegisterController extends AbstractController
{
    /**
     * @Route("/user/register", name="user_register")
     *
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EventDispatcherInterface     $eventDispatcher
     *
     * @return Response
     */
    public function __invoke(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EventDispatcherInterface $eventDispatcher
    ): Response
    {
        /** @var User $user */
        $user = new User();
        $user->setIsActive(false);
        $user->setCreatedAt(new \DateTime('now'));
        $user->setConfirmationCode(md5(microtime()));
        $user->setPassword('placeholder');

        /** @var Form $form */
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_register_success', ['user' => $user->getId()]);
        }

        return $this->render('user/registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
