<?php

namespace App\Form;

use App\Entity\ActionType;
use App\Entity\AgeCategory;
use App\Entity\Category;
//use App\Entity\ResourceType as type;
use App\Entity\RelationshipType;
use App\Entity\Resource;
use App\Entity\ResourceType as Type;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre de la ressource...',
                    'class' => 'charte-input',
                ],
                'label' => 'Titre', ])
            ->add('description', CKEditorType::class, [
                'attr' => [
                    'placeholder' => 'Nom de famille...',
                    'class' => 'charte-input',
                ],
                'label' => 'Description', ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                'imagine_pattern' => 'RessourceIMG',
                'label'=>'Illustration'
            ])
            ->add('ageCategory', EntityType::class, [
                'class' => AgeCategory::class,
                'choice_label' => function ($ageCat) {
                    return $ageCat->getLabel();
                },
                'choice_value' => 'label',
                'attr' => [
                    'class' => 'charte-input',
                ],
                'label' => 'Catégorie d\'âge', ])
            ->add('resourceType', EntityType::class, [
                'class' => Type::class,
                'choice_label' => function ($typ) {
                    return $typ->getLabel();
                },
                'choice_value' => 'label',
                'attr' => [
                    'class' => 'charte-input',
                ],
                'label' => 'Type', ])
            ->add('relationShip', EntityType::class, [
                'class' => RelationshipType::class,
                'choice_label' => function ($res) {
                    return $res->getLabel();
                },
                'choice_value' => 'label',
                'attr' => [
                    'class' => 'charte-input',
                ],
                'label' => 'Type de relation', ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function ($cat) {
                    return $cat->getLabel();
                },
                'choice_value' => 'label',
                'attr' => [
                    'class' => 'charte-input',
                ],
                'label' => 'Catégorie', ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Resource::class,
        ]);
    }
}
