<?php

namespace App\Form;

use App\Entity\ResourceGathering;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ResourceGatheringType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->traitChoices = $options['trait_choices'];
        $builder
            ->add('gathering_id', ChoiceType::class, [
                'choices' => $this->traitChoices,
                'attr' => [
                    'class' => 'charte-input',
                ],
                'label' => 'Groupe', ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResourceGathering::class,
            'trait_choices' => null,
        ]);
    }
}
