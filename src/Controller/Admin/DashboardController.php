<?php

namespace App\Controller\Admin;

use App\Entity\ActionType;
use App\Entity\AgeCategory;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Department;
use App\Entity\ManagementType;
use App\Entity\RelationshipType;
use App\Entity\RelSharedResourceUser;
use App\Entity\RelUserActionResource;
use App\Entity\Resource;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //Ressources à valider
        $resourcesToValidateNumber = $this->manager->getRepository(RelUserActionResource::class)->getResourceToValidateNumber();
        if ($resourcesToValidateNumber == -1) {
            $resourcesToValidateNumber = 'N/A';
        }

        //Ressources les plus commentées
        $resourcesMostCommented = $this->manager->getRepository(Resource::class)->getMostCommentedResources();

        //Stat du jour - Commentaires
        $currentDayCommentsNumber = $this->manager->getRepository(Comment::class)->getCurrentDayCommentNumber();
        $currentDayComments = $this->manager->getRepository(Comment::class)->getCurrentDayComments();

        //Stat du jour - Consulations
        $currentDayResourcesConsultedNumber = $this->manager->getRepository(RelUserActionResource::class)->getCurrentDayResourcesConsultedNumber();
        $currentDayResourcesConsulted = $this->manager->getRepository(Resource::class)->getCurrentDayConsultedResources();

        //Stat du jour - Partages
        $currentDaySharedResourcesNumber = $this->manager->getRepository(RelSharedResourceUser::class)->getCurrentDaySharedResourceNumber();
        $currentDaySharedResources = $this->manager->getRepository(Resource::class)->getCurrentDaySharedResources();

        //Stat de la semaine - Ressources les mieux notées
        $lastWeekBestValuatedResources = $this->manager->getRepository(Resource::class)->getLastWeekResourcesByValuation(true);

        //Stat de la semaine - Ressources les moins bien notées
        $lastWeekWorstValuatedResources = $this->manager->getRepository(Resource::class)->getLastWeekResourcesByValuation(false);

        //Stat de la semaine - Ressources les plus partagées
        $lastWeekMostSharedResources = $this->manager->getRepository(Resource::class)->getLastWeekMostSharedResources();

        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'resourcesToValidateNumber' => $resourcesToValidateNumber,
            'resourcesMostCommented' => $resourcesMostCommented,
            'currentDayCommentsNumber' => $currentDayCommentsNumber,
            'currentDayComments' => $currentDayComments,
            'currentDayResourcesConsultedNumber' => $currentDayResourcesConsultedNumber,
            'currentDayResourcesConsulted' => $currentDayResourcesConsulted,
            'currentDaySharedResourcesNumber' => $currentDaySharedResourcesNumber,
            'currentDaySharedResources' => $currentDaySharedResources,
            'lastWeekBestValuatedResources' => $lastWeekBestValuatedResources,
            'lastWeekWorstValuatedResources' => $lastWeekWorstValuatedResources,
            'lastWeekMostSharedResources' => $lastWeekMostSharedResources
        ]);
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
                        ->addCssClass('btn btn-secondary');
                }
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::DELETE,
                function (Action $action) {
                    return $action
                        ->setIcon('fa fa-trash')
                        ->setLabel(false)
                        ->addCssClass('btn btn-danger text-light')
                        ->setHtmlAttributes([
                            'style',
                        ]);
                }
            );
    }



    public function configureMenuItems(): iterable
    {
        if( $this->isGranted('ROLE_SUPER_ADMIN')||$this->isGranted('ROLE_ADMIN')){
        return [
            MenuItem::linktoDashboard('Accueil', 'fa fa-home'),
            MenuItem::section('Administration', 'fa fa-users-cog'),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class),
            MenuItem::linkToCrud('Catégories d\'ages', 'fa fa-hourglass', AgeCategory::class),
            MenuItem::linkToCrud('Rôles', 'fa fa-user-tag', Role::class),
            MenuItem::linkToCrud('Départements', 'fa fa-map-marker-alt', Department::class),
            MenuItem::section('Ressources', 'fa fa-book'),
            MenuItem::linkToCrud('Ressources', 'fa fa-book-open', Resource::class),
            MenuItem::linkToCrud('Catégorie', 'fa fa-bookmark', Category::class),
            MenuItem::linkToCrud('Type de relations', 'fa fa-people-arrows', RelationshipType::class),
            MenuItem::linkToCrud('Type de gestion', 'fa fa-star', ManagementType::class),
            MenuItem::linkToCrud('Type d\'actions', 'fa fa-hand-point-up', ActionType::class),
            MenuItem::section('Statistiques', 'fa fa-chart-pie'),
            MenuItem::linktoRoute('Utilisateurs', 'fa fa-users', 'users-stats'),
            MenuItem::linktoRoute('Resources', 'fa fa-book', 'resources-stats'),
            MenuItem::section('Documentation', 'fa fa-book'),
            MenuItem::linktoRoute('Faq', 'fa fa-book-open', 'faq'),


        ];}
        else {
        return [
            MenuItem::linktoDashboard('Accueil', 'fa fa-home'),
            MenuItem::section('Administration', 'fa fa-users-cog'),
            MenuItem::section('Ressources', 'fa fa-book'),
            MenuItem::linkToCrud('Ressources', 'fa fa-book-open', Resource::class),
            MenuItem::section('Statistiques', 'fa fa-chart-pie'),
            MenuItem::section('Documentation', 'fa fa-book'),
            MenuItem::linktoRoute('Faq', 'fa fa-book-open', 'faq'),
        ];
    }
    }
}
