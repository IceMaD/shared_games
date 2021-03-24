<?php

namespace App\Form\AddGames;

use App\Entity\Game;
use App\Form\TagifyType;
use App\Repository\GameRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddGamesType extends AbstractType
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tagifyOptions = [];

        foreach ($this->gameRepository->findAll() as $game) {
            $tagifyOptions[$game->getId()] = $game->getName();
        }

        $builder
            ->add(
                'games',
                TagifyType::class,
                [
                    'options' => $tagifyOptions,
                    'option_transformer' => fn(?int $id, string $value) => $id ? $this->gameRepository->find($id) : (new Game($value)),
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => AddGamesObject::class,
            ]
        );
    }
}
