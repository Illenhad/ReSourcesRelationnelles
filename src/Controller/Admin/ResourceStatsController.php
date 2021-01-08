<?php

namespace App\Controller\Admin;

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

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
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
        ]);
    }

    /**
     * @return int
     */
    public function numberPublicResources(): int
    {
        $nbr = 0;
        $all_resources = $this->resourceRepository->findAll();

        foreach ($all_resources as $resource)
        {
            if ($resource->isPublic()){ ++$nbr; }
        }

        return $nbr;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function countResourcePerYear(): array
    {
        $resource_per_years = [];
        $all_resources = $this->resourceRepository->findAll();
        foreach (range((new DateTime())->format('Y'), 2019) as $year) {
            foreach (range(1, 12) as $m) {
                $resource_per_years[$year][] = 0;
            }
        }

        foreach ($all_resources as $resource) {
            $date = new DateTime($resource->getFormatedDateCreation());
            try {
                ++$resource_per_years[$date->format('Y')][intval($date->format('m')) - 1];
            } catch (Exception $e) {
                $resource_per_years[$date->format('Y')][intval($date->format('m')) - 1] = 0;
            }
        }

        return $resource_per_years;
    }

    /**
     * @return array
     */
    public function resourcesPerType(): array
    {
        $resources_per_type = [];
        $all_resources = $this->resourceRepository->findAll();

        foreach ($all_resources as $resource)
        {
            try {
                ++$resources_per_type[$resource->getResourceType()->getLabel()];
            } catch (Exception $e)
            {
                $resources_per_type[$resource->getResourceType()->getLabel()] = 0;
            }
        }

        return $resources_per_type;
    }

    /**
     * @return array
     */
    public function resourcesPerCategory(): array
    {
        $resources_per_category = [];
        $all_resources = $this->resourceRepository->findAll();

        foreach ($all_resources as $resource)
        {
            try {
                ++$resources_per_category[$resource->getCategory()->getLabel()];
            } catch (Exception $e)
            {
                $resources_per_category[$resource->getCategory()->getLabel()] = 0;
            }
        }

        return $resources_per_category;
    }

    /**
     * @return array
     */
    public function resourcesPerAgeCategory(): array
    {
        $resources_per_age_category = [];
        $all_resources = $this->resourceRepository->findAll();

        foreach ($all_resources as $resource)
        {
            try {
                ++$resources_per_age_category[$resource->getAgeCategory()->getLabel()];
            } catch (Exception $e)
            {
                $resources_per_age_category[$resource->getAgeCategory()->getLabel()] = 0;
            }
        }

        return $resources_per_age_category;
    }

    /**
     * @return array
     */
    public function resourcesPerRelationshipType(): array
    {
        $resources_per_relationship_type = [];
        $all_resources = $this->resourceRepository->findAll();

        foreach ($all_resources as $resource)
        {
            try {
                ++$resources_per_relationship_type[$resource->getRelationShip()->getLabel()];
            } catch (Exception $e)
            {
                $resources_per_relationship_type[$resource->getRelationShip()->getLabel()] = 0;
            }
        }

        return $resources_per_relationship_type;
    }
}