<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'attr' => ['placeholder' => 'Ajouter un titre...',
                        'class' => 'charte-input',
                    ],
                    'label' => 'Titre',
                ]
            )
            ->add(
                'content',
                TextareaType::class,
                [
                    'attr' => [
                        'placeholder' => 'Ajouter un commentaire...',
                        'class' => 'charte-input',
                    ],

                    'label' => 'Commentaire',
                ]
            )
            ->add(
                'valuation',
                HiddenType::class,
                [
                    'attr' => [
                        'min' => 0,
                        'max' => 5,
                        'class' => ' mt-4 ',
                        'value' => 5,
                    ],
                    'label' => 'Note ',
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-primary ',
                    ],
                    'label' => 'Envoyer',

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
