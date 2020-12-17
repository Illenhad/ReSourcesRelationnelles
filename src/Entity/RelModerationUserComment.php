<?php

namespace App\Entity;

use App\Repository\RelModerationUserCommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelModerationUserCommentRepository::class)
 */
class RelModerationUserComment
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commentModerations")
     * @ORM\JoinColumn(name="moderator_id", referencedColumnName="id", nullable=false)
     */
    private $moderator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="commentModerations")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id", nullable=false)
     */
    private $resourceComment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModerationType", inversedBy="commentModerations")
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
    public function getModerator()
    {
        return $this->moderator;
    }

    /**
     * @param mixed $moderator
     * @return RelModerationUserComment
     */
    public function setModerator($moderator)
    {
        $this->moderator = $moderator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResourceComment()
    {
        return $this->resourceComment;
    }

    /**
     * @param mixed $resourceComment
     * @return RelModerationUserComment
     */
    public function setResourceComment($resourceComment)
    {
        $this->resourceComment = $resourceComment;
        return $this;
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
     * @return RelModerationUserComment
     */
    public function setModerationType($moderationType)
    {
        $this->moderationType = $moderationType;
        return $this;
    }


}