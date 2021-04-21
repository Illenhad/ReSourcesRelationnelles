<?php

namespace App\Entity;

use App\Repository\ResourceShareUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResourceShareUserRepository::class)
 */
class ResourceShareUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $shared;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $resource;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $sharing;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShared(): ?User
    {
        return $this->shared;
    }

    public function setShared(?User $shared): self
    {
        $this->shared = $shared;

        return $this;
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getSharing(): ?User
    {
        return $this->sharing;
    }

    public function setSharing(?User $sharing): self
    {
        $this->sharing = $sharing;

        return $this;
    }
}
