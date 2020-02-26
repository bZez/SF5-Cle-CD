<?php

namespace App\Form;

use App\Entity\Cle;
use App\Entity\Code;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cle')
            ->add('code',EntityType::class,['class'=>Code::class,'choice_label'=>'code_secure'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cle::class,
        ]);
    }
}
