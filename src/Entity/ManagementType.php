<?php

namespace App\Entity;

use App\Repository\ManagementTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManagementTypeRepository::class)
 */
class ManagementType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="RelUserManagementResource", mappedBy="managementType")
     *
     * @var Collection
     */
    private $resourcesUsers;

    public function __construct()
    {
        $this->resourcesUsers = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): ManagementType
    {
        $this->label = $label;

        return $this;
    }

    public function getResourcesUsers(): Collection
    {
        return $this->resourcesUsers;
    }

    public function setResourcesUsers(Collection $resourcesUsers): ManagementType
    {
        $this->resourcesUsers = $resourcesUsers;

        return $this;
    }
}
