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
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface
     */
    private $actionDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resourceActions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resource", inversedBy="userActions")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=false)
     *
     * @var resource
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActionType", inversedBy="resourceUsers")
     * @ORM\JoinColumn(name="action_type_id", referencedColumnName="id", nullable=false)
     *
     * @var ActionType
     */
    private $actionType;

    public function getId(): int
    {
        return $this->id;
    }

    public function getActionDate(): \DateTimeInterface
    {
        return $this->actionDate;
    }

    public function setActionDate(\DateTimeInterface $actionDate): RelUserActionResource
    {
        $this->actionDate = $actionDate;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): RelUserActionResource
    {
        $this->user = $user;

        return $this;
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function setResource(Resource $resource): RelUserActionResource
    {
        $this->resource = $resource;

        return $this;
    }

    public function getActionType(): ActionType
    {
        return $this->actionType;
    }

    public function setActionType(ActionType $actionType): RelUserActionResource
    {
        $this->actionType = $actionType;

        return $this;
    }
}
