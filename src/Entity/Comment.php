<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
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
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $content;

    /**
     * Should be between 0 and 5.
     *
     * @ORM\Column(type="smallint")
     *
     * @var int
     */
    private $valuation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resource", inversedBy="comments")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=false)
     *
     * @var Collection
     */
    private $resource;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserComment", mappedBy="resourceComment")
     *
     * @var Collection
     */
    private $commentModerations;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTimeInterface
     */
    private $commentDate;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->commentDate = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Comment
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Comment
    {
        $this->content = $content;

        return $this;
    }

    public function getValuation(): int
    {
        return $this->valuation;
    }

    public function setValuation(int $valuation): Comment
    {
        $this->valuation = $valuation;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Comment
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     *
     * @return Comment
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    public function getCommentModerations(): Collection
    {
        return $this->commentModerations;
    }

    public function setCommentModerations(Collection $commentModerations): Comment
    {
        $this->commentModerations = $commentModerations;

        return $this;
    }



    public function getCommentDate(): DateTimeInterface
    {
        return $this->commentDate;
    }

    public function setCommentDate(DateTimeInterface $commentDate): Comment
    {
        $this->commentDate = $commentDate;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
