<?php

namespace App\Form;

use App\Entity\AgeCategory;
use App\Entity\Department;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscribeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //TODO gestion entity departement (need link User/dep)
        $builder
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom de famille...',
                    'class' => 'charte-input',
                ],
                'label' => 'Nom', ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prenom...',
                    'class' => 'charte-input',
                ],
                'label' => 'Prenom', ])
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'Pseudo...',
                    'class' => 'charte-input',
                ],
                'label' => 'Pseudo', ])
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse mail..',
                    'class' => 'charte-input',
                ],
                'label' => 'Adresse mail', ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Mot de passe...',
                    'class' => 'charte-input',
                ],
                'label' => 'Mot de passe', ])
            ->add('confirm_password', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Comfirmer votre mot de passe!',
                    'class' => 'charte-input',
                ],
                'label' => 'Comfirmation du mot de passe', ])
            ->add('age_category', EntityType::class, [
                'class' => AgeCategory::class,
                'choice_label' => function ($ageCat) {
                    return $ageCat->getLabel();
                },
                'choice_value' => 'label',
                'attr' => [
                    'class' => 'charte-input',
                ],
                'label' => 'Catégorie d\'âge', ])
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'choice_label' => function ($dep) {
                    return $dep->getnumber().' | '.$dep->getLabel();
                },
                'choice_value' => 'label',
                'attr' => [
                    'placeholder' => 'Departement...',
                    'class' => 'charte-input',
                ],
                'label' => 'Departement', ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
