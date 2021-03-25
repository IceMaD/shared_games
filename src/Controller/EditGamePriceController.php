<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\EditGamePrice\EditGamePriceObject;
use App\Form\EditGamePrice\EditGamePriceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EditGamePriceController extends AbstractController
{
    /**
     * @Route("/games/{id}/price", name="edit_game_price", methods={"GET", "POST"})
     */
    public function __invoke(
        Game $game,
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $factory
    ): Response {
        $editPriceForm = $factory->create(EditGamePriceType::class, EditGamePriceObject::fromGame($game));

        if ($editPriceForm->handleRequest($request) && $editPriceForm->isSubmitted()) {
            /** @var EditGamePriceObject $editPriceObject */
            $editPriceObject = $editPriceForm->getData();

            $game->setPrice($editPriceObject->getPrice());

            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('edit_game_price', ['id' => $game->getId()]));
        }

        return $this->render(
            'edit_game_price.html.twig',
            [
                'game' => $game,
                'editPriceForm' => $editPriceForm->add('submit', SubmitType::class)->createView(),
            ]
        );
    }
}
