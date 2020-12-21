<?php

namespace App\Entity;

use App\Repository\RelModerationUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelModerationUserRepository::class)
 */
class RelModerationUser
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
    private $moderationDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userModerations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="moderatorModerations")
     * @ORM\JoinColumn(name="moderator_id", referencedColumnName="id", nullable=false)
     */
    private $moderator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userModerations")
     * @ORM\JoinColumn(name="moderation_type_id", referencedColumnName="id", nullable=false)
     */
    private $moderationType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModerationDate(): ?\DateTimeInterface
    {
        return $this->moderationDate;
    }

    public function setModerationDate(\DateTimeInterface $moderationDate): self
    {
        $this->moderationDate = $moderationDate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

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
    public function getModerator()
    {
        return $this->moderator;
    }

    /**
     * @param mixed $moderator
     */
    public function setModerator($moderator): void
    {
        $this->moderator = $moderator;
    }

    /**
     * @return mixed
     */
    public function getModerationType()
    {
        return $this->moderationType;
    }

    /**
     * @param mixed $moderationType
     */
    public function setModerationType($moderationType): void
    {
        $this->moderationType = $moderationType;
    }
}
