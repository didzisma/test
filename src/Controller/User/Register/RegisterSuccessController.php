<?php

declare(strict_types=1);

namespace App\Controller\User\Register;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterSuccessController
 * @package App\Controller\Profile\Register
 */
class RegisterSuccessController extends AbstractController
{
    /**
     * @Route("/user/register/success/{user}", name="user_register_success")
     * @ParamConverter("user", class="App\Entity\User")
     *
     * @param User $user
     *
     * @return Response
     */
    public function __invoke(User $user): Response
    {
        return $this->render('user/registration/success/index.html.twig', [
            'email' => $user->getEmail(),
        ]);
    }
}
