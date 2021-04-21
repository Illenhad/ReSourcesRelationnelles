<?php

namespace App\Entity;

use App\Repository\GatheringUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GatheringUserRepository::class)
 */
class GatheringUser
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
    private $User;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity=Gathering::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Gathering;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getGathering(): ?Gathering
    {
        return $this->Gathering;
    }

    public function setGathering(?Gathering $Gathering): self
    {
        $this->Gathering = $Gathering;

        return $this;
    }
}
