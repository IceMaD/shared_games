<?php

namespace App\Form\FilterGames;

use App\Entity\Tag;
use App\Form\TagifyType;
use App\Repository\GameRepository;
use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('game', TextType::class)
            ->add(
                'tags',
                TagifyType::class,
                [
                    'options' => array_reduce(
                        $this->tagRepository->findBy([], ['name' => 'asc']),
                        fn($options, Tag $tag) => $options + [$tag->getId() => $tag->getName()],
                        []
                    ),
                    'enforce_options' => true,
                ]
            );
    }
}
