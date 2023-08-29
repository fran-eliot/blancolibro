<?php

namespace App\Form;

use App\Entity\Audiovisual;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AudiovisualType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rutaAudiovisual')
            ->add('pieAudiovisual')
            ->add('fkSeccion')
            ->add('fkApartado')
            ->add('fkSubapartado')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audiovisual::class,
        ]);
    }
}
