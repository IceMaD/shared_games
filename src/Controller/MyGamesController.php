<?php

namespace App\Controller;

use App\Form\AddUserGames\AddUserGamesObject;
use App\Form\AddUserGames\AddUserGamesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class MyGamesController extends AbstractController
{
    /**
     * @Route("/my-games", name="my_games", methods={"GET", "POST"})
     */
    public function __invoke(
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        Security $security,
        FormFactoryInterface $factory
    ): Response {
        $addGamesForm = $factory->create(AddUserGamesType::class);

        if ($addGamesForm->handleRequest($request) && $addGamesForm->isSubmitted()) {
            /** @var AddUserGamesObject $addGamesObject */
            $addGamesObject = $addGamesForm->getData();

            $user = $security->getUser();

            foreach ($addGamesObject->games as $game) {
                if (!$game->getId()) {
                    $entityManager->persist($game);
                }

                $user->addGame($game);
            }

            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('my_games'));
        }

        return $this->render(
            'my_games.html.twig',
            [
                'addGamesForm' => $addGamesForm->add('submit', SubmitType::class)->createView(),
            ]
        );
    }
}
