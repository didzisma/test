<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use App\Entity\User;

/**
 * Class LoginListener
 * @package App\EventListener
 */
class LoginListener
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * LoginListener constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();

        $user->setLastLoginAt(new \DateTime('now'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}