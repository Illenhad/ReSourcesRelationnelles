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
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resourceManagements")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resource", inversedBy="userManagement")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=false)
     *
     * @var resource
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ManagementType", inversedBy="resourcesUsers")
     * @ORM\JoinColumn(name="management_type_id", referencedColumnName="id", nullable=false)
     *
     * @var ManagementType
     */
    private $managementType;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): RelUserManagementResource
    {
        $this->user = $user;

        return $this;
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function setResource(Resource $resource): RelUserManagementResource
    {
        $this->resource = $resource;

        return $this;
    }

    public function getManagementType(): ManagementType
    {
        return $this->managementType;
    }

    public function setManagementType(ManagementType $managementType): RelUserManagementResource
    {
        $this->managementType = $managementType;

        return $this;
    }
}
