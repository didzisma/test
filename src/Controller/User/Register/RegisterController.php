<?php

declare(strict_types=1);

namespace App\Controller\User\Register;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Ramsey\Uuid\Uuid;

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
     * @param \Swift_Mailer                $mailer
     *
     * @return Response
     * @throws \Exception
     */
    public function __invoke(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        \Swift_Mailer $mailer
    ): Response
    {
        /** @var User $user */
        $user = new User();
        $user->setIsActive(false);
        $user->setCreatedAt(new \DateTime('now'));
        $user->setConfirmationCode(Uuid::uuid1()->toString());
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

            $this->sendConfirmationEmail($user, $mailer);

            return $this->redirectToRoute('user_register_success', ['user' => $user->getId()]);
        }

        return $this->render('user/registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param User $user
     * @param \Swift_Mailer $mailer
     */
    private function sendConfirmationEmail(User $user, \Swift_Mailer $mailer): void
    {
        $link = $this->generateUrl(
            'user_register_confirm',
            ['code' => $user->getConfirmationCode()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $message = (new \Swift_Message('Welcome'))
            ->setFrom('hello@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig',
                    ['link' => $link]
                ),
                'text/html'
            )
        ;

        $mailer->send($message);
    }
}
