<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username')->setLabel('Identifiant'),
            TextField::new('firstname')->setLabel('Prénom'),
            TextField::new('lastname')->setLabel('Nom'),
            EmailField::new('email'),
            TextField::new('dateLastConnection')->setLabel('Dernière connexion')->hideOnForm(),
            AssociationField::new('roles')->setLabel('Rôle'),
            AssociationField::new('department')->setLabel('Lieu'),
            AssociationField::new('ageCategory')->setLabel('Catégorie d\'age'),
        ];
    }
}
