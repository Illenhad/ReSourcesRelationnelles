<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Mot de passe...',
                    'class' => 'charte-input',
                ],
                'label' => 'Nouveau mot de passe',
            ])
            ->add('confirm_password', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Comfirmer votre mot de passe!',
                    'class' => 'charte-input',
                ],
                'label' => 'Comfirmation du mot de passe',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
