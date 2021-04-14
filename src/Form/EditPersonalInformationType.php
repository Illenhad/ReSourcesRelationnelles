<?php

namespace App\Form;

use App\Entity\AgeCategory;
use App\Entity\Department;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditPersonalInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstname',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'charte-input',
                    ],
                    'label' => 'Prénom',
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'charte-input',
                    ],
                    'label' => 'Nom',
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'charte-input',
                    ],
                    'label' => 'Email',
                ]
            )
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'choice_label' => function ($dep) {
                    return $dep->getnumber().' | '.$dep->getLabel();
                },
                'choice_value' => 'label',
                'attr' => [
                    'class' => 'charte-input form-select',
                ],
                'label' => 'Departement',
                ])
            ->add('ageCategory', EntityType::class, [
                'class' => AgeCategory::class,
                'choice_label' => function ($ageCat) {
                    return $ageCat->getLabel();
                },
                'choice_value' => 'label',
                'attr' => [
                    'class' => 'charte-input form-select',
                ], ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-green ',
                        'id' => 'user_edit_submit',
                    ],
                    'label' => 'Valider',
                ])
//            ->add('firstname')
//            ->add('lastname')
//            ->add('email')
//            ->add('department')
//            ->add('ageCategory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
