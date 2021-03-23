<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    private UserRepository $repository;
    private EntityManagerInterface $entityManager;

    public function __construct(UserRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response): User
    {
        $email = $response->getEmail();
        $googleId = $response->getUsername();

        $parts = explode('@', $email);
        $domain = end($parts);

        if ('campings.com' !== $domain) {
            throw new UsernameNotFoundException();
        }

        if ($user = $this->repository->findOneBy(['googleId' => $googleId])) {
            return $user;
        }

        $user = new User($googleId, $email);

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        return $user;
    }

    public function loadUserByUsername($username): User
    {
        return $this->repository->findOneBy(['email' => $username]);
    }

    public function refreshUser(UserInterface $user): User
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}
