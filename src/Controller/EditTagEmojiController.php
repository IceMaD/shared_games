<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\EditTagEmoji\EditEmojiObject;
use App\Form\EditTagEmoji\EditTagEmojiType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EditTagEmojiController extends AbstractController
{
    /**
     * @Route("/tags/{id}/emoji", name="edit_tag_emoji", methods={"POST"})
     */
    public function __invoke(
        Tag $tag,
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $factory
    ): Response {
        $editTagEmoji = $factory->create(
            EditTagEmojiType::class,
            EditEmojiObject::fromTag($tag),
            ['action' => $urlGenerator->generate('edit_tag_emoji', ['id' => $tag->getId()])]
        );

        if ($editTagEmoji->handleRequest($request) && $editTagEmoji->isSubmitted()) {
            /** @var EditEmojiObject $editEmojiObject */
            $editEmojiObject = $editTagEmoji->getData();

            $tag->setEmoji($editEmojiObject->emoji->emoji);
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('tags'));
        }

        return $this->render(
            '_fragment/edit_tag_emoji.html.twig',
            [
                'editTagEmoji' => $editTagEmoji->createView(),
            ]
        );
    }
}
