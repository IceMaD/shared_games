<?php

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{
    /**
     * @Route("/tags", name="tags", methods={"GET"})
     */
    public function __invoke(TagRepository $tagRepository): Response
    {
        return $this->render(
            'tags.html.twig',
            [
                'tags' => $tagRepository->findAll(),
            ]
        );
    }
}
