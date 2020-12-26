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
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface
     */
    private $moderationDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var Comment
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userModerations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="moderatorModerations")
     * @ORM\JoinColumn(name="moderator_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    private $moderator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userModerations")
     * @ORM\JoinColumn(name="moderation_type_id", referencedColumnName="id", nullable=false)
     *
     * @var ModerationType
     */
    private $moderationType;

    public function getId(): int
    {
        return $this->id;
    }

    public function getModerationDate(): \DateTimeInterface
    {
        return $this->moderationDate;
    }

    public function setModerationDate(\DateTimeInterface $moderationDate): RelModerationUser
    {
        $this->moderationDate = $moderationDate;

        return $this;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function setComment(Comment $comment): RelModerationUser
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): RelModerationUser
    {
        $this->user = $user;

        return $this;
    }

    public function getModerator(): User
    {
        return $this->moderator;
    }

    public function setModerator(User $moderator): RelModerationUser
    {
        $this->moderator = $moderator;

        return $this;
    }

    public function getModerationType(): ModerationType
    {
        return $this->moderationType;
    }

    public function setModerationType(ModerationType $moderationType): RelModerationUser
    {
        $this->moderationType = $moderationType;

        return $this;
    }
}
