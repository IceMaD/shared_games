<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Tag;
use App\Form\RemoveGameTag\RemoveGameTagType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RemoveGameTagController extends AbstractController
{
    /**
     * @Route("/games/{game}/tags/{tag}", name="remove_game_tag", methods={"DELETE"})
     */
    public function __invoke(
        Request $request,
        FormFactoryInterface $formFactory,
        Game $game,
        Tag $tag,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager
    ): Response {
        $removeGameTagForm = $formFactory->create(
            RemoveGameTagType::class,
            null,
            [
                'action' => $this->generateUrl(
                    'remove_game_tag',
                    ['game' => $game->getId(), 'tag' => $tag->getId()]
                ),
            ]
        );

        if ($removeGameTagForm->handleRequest($request) && $removeGameTagForm->isSubmitted() && $removeGameTagForm->isValid()) {
            $game->removeTag($tag);
            $entityManager->flush($game);

            return new RedirectResponse($urlGenerator->generate('edit_game_tags', ['id' => $game->getId()]));
        }

        return $this->render(
            '_fragment/remove_game_tag.html.twig',
            ['removeGameTagForm' => $removeGameTagForm->createView()]
        );
    }
}
