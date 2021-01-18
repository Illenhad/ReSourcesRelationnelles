<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old_password', PasswordType::class, [
                'label' => 'Mot de passe',
            ])
            ->add('new_password', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
            ])
            ->add('new_password_confirm', PasswordType::class, [
                'label' => 'Confirmez le nouveau mot de passe',
            ])
        ;
    }
}
