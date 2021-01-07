<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->renderContentMaximized();
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->disable(Action::NEW);
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
            AssociationField::new('role')->setLabel('Rôle'),
            AssociationField::new('department')->setLabel('Lieu'),
            AssociationField::new('ageCategory')->setLabel('Catégorie d\'age'),
            TextField::new('password')
                ->hideOnIndex()
                ->setFormType(PasswordType::class)
                ->onlyWhenCreating()
                ->setLabel('Mot de passe'),
            TextField::new('confirm_password')
                ->hideOnIndex()
                ->setFormType(PasswordType::class)
                ->onlyWhenCreating()
                ->setLabel('Confirmation mot de passe'),
            BooleanField::new('active')->setLabel('Compte activé')
        ];
    }
}
