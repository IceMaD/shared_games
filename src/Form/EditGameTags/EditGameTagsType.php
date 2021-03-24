<?php

namespace App\Form\EditGameTags;

use App\Entity\Game;
use App\Entity\Tag;
use App\Form\TagifyType;
use App\Repository\GameRepository;
use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditGameTagsType extends AbstractType
{
    private TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'tags',
                TagifyType::class,
                [
                    'options' => array_reduce(
                        $this->tagRepository->findAll(),
                        fn ($options, Tag $tag) => $options + [$tag->getId() => $tag->getName()],
                        []
                    ),
                    'option_transformer' => fn(?int $id, string $value) => $id ? $this->tagRepository->find($id) : (new Tag($value)),
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => EditGameTagsObject::class,
            ]
        );
    }
}
