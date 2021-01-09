<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old_password', null, [
                'label' => 'Mot de passe'
            ])
            ->add('new_password', null, [
                'label' => 'Nouveau mot de passe'
            ])
            ->add('new_password_confirm', null, [
                'label' => 'Confirmez le nouveau mot de passe'
            ])
        ;
    }
}
