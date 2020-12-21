<?php

namespace App\Entity;

use App\Repository\RelModerationUserResourceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelModerationUserResourceRepository::class)
 */
class RelModerationUserResource
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
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resourceModerations")
     * @ORM\JoinColumn(name="moderator_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    private $moderator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resource", inversedBy="resourceModerations")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=false)
     *
     * @var resource
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModerationType", inversedBy="resourceModeration")
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

    public function setModerationDate(\DateTimeInterface $moderationDate): RelModerationUserResource
    {
        $this->moderationDate = $moderationDate;

        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): RelModerationUserResource
    {
        $this->comment = $comment;

        return $this;
    }

    public function getModerator(): User
    {
        return $this->moderator;
    }

    public function setModerator(User $moderator): RelModerationUserResource
    {
        $this->moderator = $moderator;

        return $this;
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function setResource(Resource $resource): RelModerationUserResource
    {
        $this->resource = $resource;

        return $this;
    }

    public function getModerationType(): ModerationType
    {
        return $this->moderationType;
    }

    public function setModerationType(ModerationType $moderationType): RelModerationUserResource
    {
        $this->moderationType = $moderationType;

        return $this;
    }
}
