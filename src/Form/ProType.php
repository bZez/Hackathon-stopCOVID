<?php

namespace App\Form;

use App\Entity\Pro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,['attr'=>[
                'placeholder'=>'Votre adresse email...'
            ],'label'=>false])
            ->add('firstname',TextType::class,['attr'=>[
                'placeholder'=>'Votre prénom...'
            ]])
            ->add('lastname',TextType::class,['attr'=>[
                'placeholder'=>'Votre nom...'
            ]])
            ->add('siret',TextType::class,['attr'=>[
                'placeholder'=>'Votre N° de Sécurité Social...'
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
            ->add('password')
            ->add('type',EntityType::class,['class'=>\App\Entity\ProType::class,'choice_label'=>'label'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pro::class,
        ]);
    }
}
