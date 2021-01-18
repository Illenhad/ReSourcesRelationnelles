<?php

namespace App\Entity;

use App\Repository\RelSharedResourcesUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass=RelSharedResourcesUserRepository::class)
 */
class RelSharedResourceUser
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
     * @ManyToOne(targetEntity="App\Entity\User", inversedBy="shareUsers")
     * @JoinColumn(name="sharer_user_id", referencedColumnName="id")
     *
     * @var User
     */
    private $sharerUser;

    /**
     * @ManyToOne(targetEntity="App\Entity\User", inversedBy="sharedWithUsers")
     * @JoinColumn(name="shared_with_user_id", referencedColumnName="id")
     *
     * @var User
     */
    private $sharedWithUser;

    /**
     * @ManyToOne(targetEntity="App\Entity\Resource", inversedBy="sharedResources")
     * @JoinColumn(name="resource_id", referencedColumnName="id")
     *
     * @var resource
     */
    private $resource;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSharerUser(): User
    {
        return $this->sharerUser;
    }

    public function setSharerUser(User $sharerUser): RelSharedResourceUser
    {
        $this->sharerUser = $sharerUser;

        return $this;
    }

    public function getSharedWithUser(): User
    {
        return $this->sharedWithUser;
    }

    public function setSharedWithUser(User $sharedWithUser): RelSharedResourceUser
    {
        $this->sharedWithUser = $sharedWithUser;

        return $this;
    }

    public function getResource(): resource
    {
        return $this->resource;
    }

    public function setResource(resource $resource): RelSharedResourceUser
    {
        $this->resource = $resource;

        return $this;
    }
}
