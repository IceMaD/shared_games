<?php

namespace App\Form\RemoveGameTag;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RemoveGameTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('Delete', SubmitType::class, ['attr'=> ['class' => 'button']]);
    }
}
