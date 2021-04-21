<?php

namespace App\Entity;

use App\Repository\ResourceGatheringRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResourceGatheringRepository::class)
 */
class ResourceGathering
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
     * @ORM\ManyToOne(targetEntity=Gathering::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $gathering;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $sharing_user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $gathering_id;

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

    public function getGathering(): ?Gathering
    {
        return $this->gathering;
    }

    public function setGathering(?Gathering $gathering): self
    {
        $this->gathering = $gathering;

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

    public function getGatheringId(): ?int
    {
        return $this->gathering_id;
    }

    public function setGatheringId(?int $gathering_id): self
    {
        $this->gathering_id = $gathering_id;

        return $this;
    }
}
