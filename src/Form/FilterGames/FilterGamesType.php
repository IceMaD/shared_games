<?php

namespace App\Form\FilterGames;

use App\Entity\Game;
use App\Entity\Tag;
use App\Form\TagifyType;
use App\Repository\GameRepository;
use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterGamesType extends AbstractType
{
    private GameRepository $gameRepository;
    private TagRepository $tagRepository;

    public function __construct(GameRepository $gameRepository, TagRepository $tagRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->tagRepository = $tagRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add(
//                'games',
//                TagifyType::class,
//                [
//                    'options' => array_reduce(
//                        $this->gameRepository->findAll(),
//                        fn($options, Game $game) => $options + [$game->getId() => $game->getName()],
//                        []
//                    ),
//                    'enforce_options' => true,
//                ]
//            )
            ->add(
                'tags',
                TagifyType::class,
                [
                    'options' => array_reduce(
                        $this->tagRepository->findAll(),
                        fn($options, Tag $tag) => $options + [$tag->getId() => $tag->getName()],
                        []
                    ),
                    'enforce_options' => true,
                ]
            );
    }
}
