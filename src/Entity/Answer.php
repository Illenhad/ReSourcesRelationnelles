<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
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
     * @ManyToOne(targetEntity="App\Entity\Commentary", inversedBy="answers")
     * @JoinColumn(name="commentary_id", referencedColumnName="id")
     *
     * @var Commentary
     */
    private $commentary;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserAnswer", mappedBy="answer")
     *
     * @var Collection
     */
    private $relModerationUserAnswers;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $content;

    /**
     * @ManyToOne(targetEntity="App\Entity\User", inversedBy="answers")
     * @JoinColumn(name="usert_id", referencedColumnName="id")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface
     */
    private $answerDate;

    public function __construct()
    {
        $this->relModerationUserAnswers = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRelModerationUserAnswers(): Collection
    {
        return $this->relModerationUserAnswers;
    }

    public function setRelModerationUserAnswers(Collection $relModerationUserAnswers): Answer
    {
        $this->relModerationUserAnswers = $relModerationUserAnswers;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Answer
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Answer
    {
        $this->user = $user;

        return $this;
    }

    public function getAnswerDate(): \DateTimeInterface
    {
        return $this->answerDate;
    }

    public function setAnswerDate(\DateTimeInterface $answerDate): Answer
    {
        $this->answerDate = $answerDate;

        return $this;
    }

    public function getCommentary(): Commentary
    {
        return $this->commentary;
    }

    public function setCommentary(Commentary $commentary): Answer
    {
        $this->commentary = $commentary;

        return $this;
    }


}
