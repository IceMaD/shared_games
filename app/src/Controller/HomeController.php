<?php

namespace App\Controller;

use App\Form\FilterGames\FilterGamesType;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function __invoke(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        GameRepository $gameRepository,
        UserRepository $userRepository
    ): Response {
        return $this->render(
            'home.html.twig',
            [
                'filterGamesForm' => $formFactory->create(FilterGamesType::class)->createView(),
                'games' => $gameRepository->findAll(),
                'users' => $userRepository->findAll(),
            ]
        );
    }
}
