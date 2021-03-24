<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\EditGameTags\EditGameTagsObject;
use App\Form\EditGameTags\EditGameTagsType;
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

class EditGameTagsController extends AbstractController
{
    /**
     * @Route("/games/{id}/tags", name="edit_game_tags")
     */
    public function index(
        Game $game,
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $factory
    ): Response {
        $editTagsForm = $factory->create(EditGameTagsType::class);

        if ($editTagsForm->handleRequest($request) && $editTagsForm->isSubmitted()) {
            /** @var EditGameTagsObject $editTagsObject */
            $editTagsObject = $editTagsForm->getData();

            foreach ($editTagsObject->tags as $tag) {
                if (!$tag->getId()) {
                    $entityManager->persist($tag);
                }

                $game->addTag($tag);
            }

            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('edit_game_tags', ['id' => $game->getId()]));
        }

        return $this->render(
            'edit_game_tags.html.twig',
            [
                'game' => $game,
                'editTagsForm' => $editTagsForm->add('submit', SubmitType::class)->createView(),
            ]
        );
    }
}
