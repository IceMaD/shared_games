<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmojiType extends AbstractType
{
    public function getBlockPrefix()
    {
        return 'emoji';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = uniqid();

        $builder
            ->add('emoji', HiddenType::class, ['attr' => ['emoji-hidden' => $id]])
            ->add(
                'picker',
                ButtonType::class,
                [
                    'label' => $builder->getData()->emoji,
                    'attr' => ['emoji-pick' => $id],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(
            [
                'data_class' => EmojiObject::class,
                'label' => false,
                'picker_label' => '❌',
            ]
        );
    }
}
