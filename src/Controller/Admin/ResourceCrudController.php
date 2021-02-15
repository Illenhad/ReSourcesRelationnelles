<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ResourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Resource::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->disable(Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('link'),
            TextEditorField::new('imageFile')->setFormType(VichImageType::class)->setTranslationParameters(['form.label.delete'=>'Supprimer/modifier']),
            TextareaField::new('contentFile')->setFormType(VichFileType::class)->setTranslationParameters(['form.label.delete'=>'Supprimer/modifier']),
            TextEditorField::new('description'),
            BooleanField::new('public'),
            DateField::new('dateCreation')->setFormat('dd/MM/yyyy H:mm')->hideOnForm(),
            AssociationField::new('ageCategory'),
            AssociationField::new('category'),
            AssociationField::new('user'),
            AssociationField::new('resourceType'),
            AssociationField::new('relationShip'),
            AssociationField::new('comments')->onlyWhenUpdating(),
            BooleanField::new('active')->setLabel('Ressource active'),
        ];
    }
}
