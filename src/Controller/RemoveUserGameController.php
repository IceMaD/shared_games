<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\RemoveUserGame\RemoveUserGameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class RemoveUserGameController extends AbstractController
{
    /**
     * @Route("/games/{game}", name="remove_user_game", methods={"DELETE"})
     */
    public function __invoke(
        Request $request,
        FormFactoryInterface $formFactory,
        Game $game,
        Security $security,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager
    ): Response {
        $removeUserGameForm = $formFactory->create(
            RemoveUserGameType::class,
            null,
            [
                'action' => $this->generateUrl('remove_user_game', ['game' => $game->getId()]),
            ]
        );

        if ($removeUserGameForm->handleRequest($request) && $removeUserGameForm->isSubmitted() && $removeUserGameForm->isValid()) {
            $user = $security->getUser();
            $user->removeGame($game);
            $entityManager->flush($user);

            return new RedirectResponse($urlGenerator->generate('my_games'));
        }

        return $this->render(
            '_fragment/remove_user_game.html.twig',
            ['removeUserGameForm' => $removeUserGameForm->createView()]
        );
    }
}
