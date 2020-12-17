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
     * @var Resource
     */
    private $resource;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getSharerUser(): User
    {
        return $this->sharerUser;
    }

    /**
     * @param User $sharerUser
     * @return RelSharedResourceUser
     */
    public function setSharerUser(User $sharerUser): RelSharedResourceUser
    {
        $this->sharerUser = $sharerUser;
        return $this;
    }

    /**
     * @return User
     */
    public function getSharedWithUser(): User
    {
        return $this->sharedWithUser;
    }

    /**
     * @param User $sharedWithUser
     * @return RelSharedResourceUser
     */
    public function setSharedWithUser(User $sharedWithUser): RelSharedResourceUser
    {
        $this->sharedWithUser = $sharedWithUser;
        return $this;
    }

    /**
     * @return Resource
     */
    public function getResource(): Resource
    {
        return $this->resource;
    }

    /**
     * @param Resource $resource
     * @return RelSharedResourceUser
     */
    public function setResource(Resource $resource): RelSharedResourceUser
    {
        $this->resource = $resource;
        return $this;
    }


}
