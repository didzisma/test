<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomepageController
 * @package App\Controller
 */
class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user instanceof User) {
            return $this->render('homepage/news.html.twig');
        }

        return $this->render('homepage/index.html.twig');
    }
}
