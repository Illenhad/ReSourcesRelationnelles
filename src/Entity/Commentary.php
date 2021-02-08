<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaryRepository")
 */
class Commentary
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
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var User|UserInterface
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTimeInterface
     */
    private $commentDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resource", inversedBy="commentaries")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=false)
     *
     * @var resource
     */
    private $resource;

    /**
     * @OneToMany(targetEntity="App\Entity\Answer", mappedBy="commentary")
     *
     * @var Collection
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->commentDate = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): ?Commentary
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): Commentary
    {
        $this->user = $user;

        return $this;
    }

    public function getCommentDate(): ?DateTimeInterface
    {
        return $this->commentDate;
    }

    public function setCommentDate(DateTimeInterface $commentDate): Commentary
    {
        $this->commentDate = $commentDate;

        return $this;
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function setResource(Resource $resource): Commentary
    {
        $this->resource = $resource;

        return $this;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function setAnswers(Collection $answers): Commentary
    {
        $this->answers = $answers;

        return $this;
    }
}
