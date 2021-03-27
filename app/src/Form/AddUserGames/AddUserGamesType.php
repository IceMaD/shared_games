<?php

namespace App\Form\AddUserGames;

use App\Entity\Game;
use App\Form\TagifyType;
use App\Repository\GameRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUserGamesType extends AbstractType
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'games',
                TagifyType::class,
                [
                    'options' => array_reduce(
                        $this->gameRepository->findBy([], ['name' => 'asc']),
                        fn ($options, Game $game) => $options + [$game->getId() => $game->getName()],
                        []
                    ),
                    'option_transformer' => fn(?int $id, string $value) => $id ? $this->gameRepository->find($id) : (new Game($value)),
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => AddUserGamesObject::class,
            ]
        );
    }
}
