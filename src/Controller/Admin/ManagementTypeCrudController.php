<?php

namespace App\Controller\Admin;

use App\Entity\ManagementType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ManagementTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ManagementType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label'),
        ];
    }
}
