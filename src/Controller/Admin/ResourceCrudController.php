<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ResourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Resource::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('link'),
            TextEditorField::new('description'),
            BooleanField::new('public'),
            DateField::new('dateCreation')->setFormat('dd/MM/yyyy H:mm')->hideOnForm(),
            AssociationField::new('ageCategory'),
            AssociationField::new('category'),
            AssociationField::new('user'),
            AssociationField::new('resourceType'),
            AssociationField::new('relationShip'),
            AssociationField::new('comments')->onlyWhenUpdating(),
        ];
    }
}
