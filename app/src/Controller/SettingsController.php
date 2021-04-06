<?php

namespace App\Controller;

use App\Form\AddUserGames\AddUserGamesObject;
use App\Form\AddUserGames\AddUserGamesType;
use App\Form\Settings\SettingsObject;
use App\Form\Settings\SettingsType;
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

class SettingsController extends AbstractController
{
    /**
     * @Route("/settings", name="settings", methods={"GET", "POST"})
     */
    public function __invoke(
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        Security $security,
        FormFactoryInterface $factory,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $security->getUser();

        $settingsForm = $factory->create(SettingsType::class, SettingsObject::fromUser($user));

        if ($settingsForm->handleRequest($request) && $settingsForm->isSubmitted()) {
            /** @var SettingsObject $settingsObject */
            $settingsObject = $settingsForm->getData();

            $user->setPseudo($settingsObject->pseudo);

            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('settings'));
        }

        return $this->render(
            'settings.html.twig',
            [
                'settingsForm' => $settingsForm->add('submit', SubmitType::class)->createView(),
            ]
        );
    }
}
