<?php

namespace App\Entity;

use App\Repository\RelUserActionResourceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelUserActionResourceRepository::class)
 */
class RelUserActionResource
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $actionDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resourceActions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resource", inversedBy="userActions")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=false)
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActionType", inversedBy="resourceUsers")
     * @ORM\JoinColumn(name="action_type_id", referencedColumnName="id", nullable=false)
     */
    private $actionType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionDate(): ?\DateTimeInterface
    {
        return $this->actionDate;
    }

    public function setActionDate(\DateTimeInterface $actionDate): self
    {
        $this->actionDate = $actionDate;

        return $this;
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
    public function getActionType()
    {
        return $this->actionType;
    }

    /**
     * @param mixed $actionType
     */
    public function setActionType($actionType): void
    {
        $this->actionType = $actionType;
    }
}
