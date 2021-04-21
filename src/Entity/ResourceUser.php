<?php

namespace App\Entity;

use App\Repository\ResourceUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResourceUserRepository::class)
 */
class ResourceUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $sharing_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    public function getSharedUser(): ?User
    {
        return $this->user;
    }

    public function setSharedUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSharingUser(): ?User
    {
        return $this->sharing_user;
    }

    public function setSharingUser(?User $sharing_user): self
    {
        $this->sharing_user = $sharing_user;

        return $this;
    }
}
