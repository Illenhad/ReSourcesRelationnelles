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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commentModerations")
     * @ORM\JoinColumn(name="moderator_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    private $moderator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="commentModerations")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id", nullable=false)
     *
     * @var Comment
     */
    private $resourceComment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModerationType", inversedBy="commentModerations")
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

    public function setModerationDate(\DateTimeInterface $moderationDate): RelModerationUserComment
    {
        $this->moderationDate = $moderationDate;

        return $this;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function setComment(Comment $comment): RelModerationUserComment
    {
        $this->comment = $comment;

        return $this;
    }

    public function getModerator(): User
    {
        return $this->moderator;
    }

    public function setModerator(User $moderator): RelModerationUserComment
    {
        $this->moderator = $moderator;

        return $this;
    }

    public function getResourceComment(): Comment
    {
        return $this->resourceComment;
    }

    public function setResourceComment(Comment $resourceComment): RelModerationUserComment
    {
        $this->resourceComment = $resourceComment;

        return $this;
    }

    public function getModerationType(): ModerationType
    {
        return $this->moderationType;
    }

    public function setModerationType(ModerationType $moderationType): RelModerationUserComment
    {
        $this->moderationType = $moderationType;

        return $this;
    }
}
