<?php

namespace App\Entity;

use App\Repository\GatheringInviteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GatheringInviteRepository::class)
 */
class GatheringInvite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Gathering::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $gathering;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $invited;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $inviting;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getInvited(): ?User
    {
        return $this->invited;
    }

    public function setInvited(?User $invited): self
    {
        $this->invited = $invited;

        return $this;
    }

    public function getInviting(): ?User
    {
        return $this->inviting;
    }

    public function setInviting(?User $inviting): self
    {
        $this->inviting = $inviting;

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
}
