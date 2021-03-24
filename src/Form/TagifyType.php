<?php

namespace App\Form;

use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagifyType extends TextType
{
    public function getBlockPrefix()
    {
        return 'tagify';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(
            new CallbackTransformer(
                function () {
//                    dump(func_get_args());
//                    die;
                },
                fn(string $submittedData) => array_map(
                    fn(array $tag) => $options['option_transformer']($tag['id'] ?? null, $tag['value']),
                    json_decode($submittedData, true)
                ),
            )
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['options'] = $options['options'];
        $view->vars['max_tags'] = $options['max_tags'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(
            [
                'options' => null,
                'max_tags' => null,
                'option_transformer' => null,
            ]
        );

        $resolver->setAllowedTypes('options', ['array']);
        $resolver->setAllowedTypes('max_tags', ['int', 'null']);
        $resolver->setAllowedTypes('option_transformer', ['callable']);
    }
}
