<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,['attr'=>[
                'readonly' => true
            ]])
            ->add('email',EmailType::class,['attr'=>[
                'placeholder'=>'Votre adresse email...'
            ],'label'=>false])
            ->add('firstname',TextType::class,['attr'=>[
                'placeholder'=>'Votre prénom...'
            ]])
            ->add('lastname',TextType::class,['attr'=>[
                'placeholder'=>'Votre nom...'
            ]])
            ->add('insee',TextType::class,['attr'=>[
                'placeholder'=>'Votre N° de Sécurité Social...'
            ]])
            ->add('mutuelle',TextType::class,['attr'=>[
                'placeholder'=>'Mutuelle (facultatif)...'
            ]])
            ->add('address',TextType::class,['attr'=>[
                'placeholder'=>'Votre adresse...'
            ]])
            ->add('city',TextType::class,['attr'=>[
                'placeholder'=>'Ville...'
            ]])
            ->add('zipcode',TextType::class,['attr'=>[
                'placeholder'=>'Code postal...'
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
