<?php

namespace App\Controller\Admin;

use App\Entity\ActionType;
use App\Entity\AgeCategory;
use App\Entity\Category;
use App\Entity\Department;
use App\Entity\ManagementType;
use App\Entity\RelationshipType;
use App\Entity\Resource;
use App\Entity\Role;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @var array : few statistics passed in view
     */
    private $stats_prop;

    /**
     * @var array : last 5 ressources created
     */
    private $last_ress;

    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        // TODO: données de tests, créer la récupération en base
        $this->stats_prop = [
            ['title' => 'Utilisateur(s) connecté(s)', 'value' => 85, 'class' => 'bg-success'],
            ['title' => 'Modérateur(s) connecté(s)', 'value' => 12, 'class' => 'bg-primary'],
            ['title' => 'Ressource(s) en attente de validation', 'value' => 204, 'class' => 'bg-dark'],
            ['title' => 'Ressource(s) à vérifier', 'value' => 72, 'class' => 'bg-dark']
        ];
        $this->last_ress = [
            ['id' => 597, 'name' => 'Les bienfaits de la méditation', 'user' => 'kevindu62', 'date' => '12-12-2020 20h30'],
            ['id' => 596, 'name' => 'La permaculture pour les nuls', 'user' => 'bgtuning', 'date' => '12-12-2020 20h29'],
            ['id' => 595, 'name' => 'La croche, tu décroches !', 'user' => 'amandinedu38', 'date' => '12-12-2020 20h25'],
            ['id' => 594, 'name' => 'Reconnaitre l\'intolérance au lactose', 'user' => 'lavachekiri', 'date' => '12-12-2020 20h10'],
            ['id' => 592, 'name' => 'Je suis le meilleurs', 'user' => 'michaelvandetta', 'date' => '12-12-2020 19h59']
        ];
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'stats_prop' => $this->stats_prop,
            'last_ress' => $this->last_ress
        ]);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('[RE]Sources<br//>Relationnelles')
            ->renderContentMaximized(true);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->update(
                Crud::PAGE_INDEX,
                Action::EDIT,
                function (Action $action) {
                    return $action
                        ->setIcon('fa fa-pencil')
                        ->setLabel(false)
                        ->addCssClass("btn btn-secondary");
                })
            ->update(
                Crud::PAGE_INDEX,
                Action::DELETE,
                function (Action $action) {
                    return $action
                        ->setIcon('fa fa-trash')
                        ->setLabel(false)
                        ->addCssClass("btn btn-danger text-light")
                        ->setHtmlAttributes([
                            'style'
                        ]);
                });
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Accueil', 'fa fa-home'),
            MenuItem::section('Administration', 'fa fa-users-cog'),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class),
            MenuItem::linkToCrud('Catégories d\'ages', 'fa fa-hourglass', AgeCategory::class), // TODO: corriger
            MenuItem::linkToCrud('Rôles', 'fa fa-user-tag', Role::class),
            MenuItem::linkToCrud('Départements', 'fa fa-map-marker-alt', Department::class),
            MenuItem::section('Ressources', 'fa fa-book'),
            MenuItem::linkToCrud('Ressources', 'fa fa-book-open', Resource::class),
            MenuItem::linkToCrud('Catégorie', 'fa fa-bookmark', Category::class),
            MenuItem::linkToCrud('Type de relations', 'fa fa-people-arrows', RelationshipType::class),
            MenuItem::linkToCrud('Type de gestion', 'fa fa-star', ManagementType::class),
            MenuItem::linkToCrud('Type d\'actions', 'fa fa-hand-point-up', ActionType::class),
            MenuItem::section('Statistiques', 'fa fa-chart-pie'),
            MenuItem::linktoRoute('Utilisateurs', 'fa fa-chart-pie', 'users-stats')
            // TODO: Ajouter la gestion des statistiques
        ];
    }
}
