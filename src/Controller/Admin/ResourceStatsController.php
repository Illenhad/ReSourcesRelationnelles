<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use App\Repository\ResourceRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResourceStatsController extends AbstractController
{
    /**
     * @var ResourceRepository
     */
    private $resourceRepository;
    /**
     * @var resource[]
     */
    private $all_resources;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->all_resources = $this->resourceRepository->findAll();
    }

    /**
     * @Route("/resources-stats", name="resources-stats")
     *
     * @throws Exception
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/page/resources_stats.html.twig', [
            'resources' => $this->resourceRepository->findAll(),
            'resources_public' => $this->numberPublicResources(),
            'resources_per_year' => $this->countResourcePerYear(),
            'resources_per_type' => $this->resourcesPerType(),
            'resources_per_category' => $this->resourcesPerCategory(),
            'resources_per_age_category' => $this->resourcesPerAgeCategory(),
            'resources_per_relationship_type' => $this->resourcesPerRelationshipType(),
            'resource_active' => $this->countResourceActive(),
        ]);
    }

    public function numberPublicResources(): int
    {
        $nbr = 0;
        $all_resources = $this->resourceRepository->findAll();

        foreach ($all_resources as $resource) {
            if ($resource->isPublic()) {
                ++$nbr;
            }
        }

        return $nbr;
    }

    /**
     * @throws Exception
     */
    private function countResourcePerYear(): array
    {
        $resource_per_years = [];
        foreach (range((new DateTime())->format('Y'), 2019) as $year) {
            foreach (range(1, 12) as $m) {
                $resource_per_years[$year][] = 0;
            }
        }

        foreach ($this->all_resources as $resource) {
            $date = new DateTime($resource->getFormatedDateCreation());
            try {
                ++$resource_per_years[$date->format('Y')][intval($date->format('m')) - 1];
            } catch (Exception $e) {
                $resource_per_years[$date->format('Y')][intval($date->format('m')) - 1] = 0;
            }
        }

        return $resource_per_years;
    }

    public function resourcesPerType(): array
    {
        $resources_per_type = [];

        foreach ($this->all_resources as $resource) {
            try {
                ++$resources_per_type[$resource->getResourceType()->getLabel()];
            } catch (Exception $e) {
                $resources_per_type[$resource->getResourceType()->getLabel()] = 0;
            }
        }

        return $resources_per_type;
    }

    public function resourcesPerCategory(): array
    {
        $resources_per_category = [];

        foreach ($this->all_resources as $resource) {
            try {
                ++$resources_per_category[$resource->getCategory()->getLabel()];
            } catch (Exception $e) {
                $resources_per_category[$resource->getCategory()->getLabel()] = 0;
            }
        }

        return $resources_per_category;
    }

    public function resourcesPerAgeCategory(): array
    {
        $resources_per_age_category = [];

        foreach ($this->all_resources as $resource) {
            try {
                ++$resources_per_age_category[$resource->getAgeCategory()->getLabel()];
            } catch (Exception $e) {
                $resources_per_age_category[$resource->getAgeCategory()->getLabel()] = 0;
            }
        }

        return $resources_per_age_category;
    }

    public function countResourceActive(): int
    {
        $resource_active = 0;

        foreach ($this->all_resources as $resource) {
            if ($resource->getActive()) {
                ++$resource_active;
            }
        }

        return $resource_active;
    }

    public function resourcesPerRelationshipType(): array
    {
        $resources_per_relationship_type = [];

        foreach ($this->all_resources as $resource) {
            try {
                ++$resources_per_relationship_type[$resource->getRelationShip()->getLabel()];
            } catch (Exception $e) {
                $resources_per_relationship_type[$resource->getRelationShip()->getLabel()] = 0;
            }
        }

        return $resources_per_relationship_type;
    }
}
