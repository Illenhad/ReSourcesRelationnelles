<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
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
                        'class' => 'form-control',
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
                        'class' => 'form-control',
                    ],

                    'label' => 'Commentaire',
                ]
            )
            ->add(
                'valuation',
                TextareaType::class,
                [
                    'attr' => [
                        'placeholder' => 'Ajouter une évaluation...',
                        'class' => 'form-control',
                    ],
                    'label' => 'Evaluation',
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
