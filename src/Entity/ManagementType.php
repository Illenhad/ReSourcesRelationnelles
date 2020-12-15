<?php

namespace App\Entity;

use App\Repository\ManagementTypeRepository;
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="RelUserManagementResource", mappedBy="managementType")
     */
    private $resourcesUsers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResourcesUsers()
    {
        return $this->resourcesUsers;
    }

    /**
     * @param mixed $resourcesUsers
     */
    public function setResourcesUsers($resourcesUsers): void
    {
        $this->resourcesUsers = $resourcesUsers;
    }


}
