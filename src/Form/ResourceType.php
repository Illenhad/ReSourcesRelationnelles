<?php

namespace App\Form;

use App\Entity\Resource;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', CKEditorType::class)
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                'imagine_pattern' => 'RessourceIMG',
                'label'=>'Illustration'
            ])
            ->add('ageCategory')
            ->add('resourceType')
            ->add('relationShip')
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Resource::class,
        ]);
    }
}
