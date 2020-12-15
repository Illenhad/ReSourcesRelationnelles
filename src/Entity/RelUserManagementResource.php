<?php

namespace App\Entity;

use App\Repository\RelUserManagementResourceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelUserManagementResourceRepository::class)
 */
class RelUserManagementResource
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resourceManagements")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resource", inversedBy="userManagement")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=false)
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ManagementType", inversedBy="resourcesUsers")
     * @ORM\JoinColumn(name="management_type_id", referencedColumnName="id", nullable=false)
     */
    private $managementType;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource): void
    {
        $this->resource = $resource;
    }

    /**
     * @return mixed
     */
    public function getManagementType()
    {
        return $this->managementType;
    }

    /**
     * @param mixed $managementType
     */
    public function setManagementType($managementType): void
    {
        $this->managementType = $managementType;
    }


}
