<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Feed\Source\Tvnet as FeedReader;
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
     * @param FeedReader $feedReader
     *
     * @return Response
     */
    public function index(
        FeedReader $feedReader
    ): Response
    {
        if ($this->getUser() instanceof User) {
            return $this->render($feedReader->getTemplate(), [
                'feed' => $feedReader->getData()
            ]);
        }

        return $this->render('homepage/index.html.twig');
    }
}
