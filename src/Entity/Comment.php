<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valuation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resource", inversedBy="comments")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=false)
     */
    private $resource;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserComment", mappedBy="resourceComment")
     */
    private $commentModeration;

    /**
     * @OneToMany(targetEntity="App\Entity\Answer", mappedBy="comment")
     */
    private $answers;

    /**
     * @ORM\Column(type="date")
     */
    private $commentDate;
    /**
     * @var mixed
     */
    private $commentParent;
    /**
     * @var mixed
     */
    private $responses;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getValuation(): ?string
    {
        return $this->valuation;
    }

    public function setValuation(string $valuation): self
    {
        $this->valuation = $valuation;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentParent()
    {
        return $this->commentParent;
    }

    /**
     * @param mixed $commentParent
     */
    public function setCommentParent($commentParent): void
    {
        $this->commentParent = $commentParent;
    }

    /**
     * @return mixed
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param mixed $responses
     */
    public function setResponses($responses): void
    {
        $this->responses = $responses;
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
     *
     * @return self
     */
    public function setUser($user): self
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
     */
    public function setResource($resource): void
    {
        $this->resource = $resource;
    }

    /**
     * @return mixed
     */
    public function getCommentModeration()
    {
        return $this->commentModeration;
    }

    /**
     * @param mixed $commentModeration
     */
    public function setCommentModeration($commentModeration): void
    {
        $this->commentModeration = $commentModeration;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnswers(): ArrayCollection
    {
        return $this->answers;
    }

    /**
     * @param ArrayCollection $answers
     * @return Comment
     */
    public function setAnswers(ArrayCollection $answers): Comment
    {
        $this->answers = $answers;
        return $this;
    }

    public function getCommentDate(): ?DateTimeInterface
    {
        return $this->commentDate;
    }

    public function setCommentDate(DateTimeInterface $commentDate): self
    {
        $this->commentDate = $commentDate;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

}
