<?php

namespace App\Form\EditTagEmoji;

use App\Form\EmojiType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTagEmojiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'emoji',
            EmojiType::class,
            [
                'data' => $builder->getData()->emoji,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('method', 'POST');
    }
}
