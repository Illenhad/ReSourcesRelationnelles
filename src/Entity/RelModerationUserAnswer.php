<?php

namespace App\Entity;

use App\Repository\RelModerationUserAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelModerationUserAnswerRepository::class)
 */
class RelModerationUserAnswer
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="answerModerations")
     * @ORM\JoinColumn(name="moderator_id", referencedColumnName="id")
     */
    private $moderator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModerationType", inversedBy="answerModerations")
     * @ORM\JoinColumn(name="moderation_id", referencedColumnName="id")
     */
    private $moderationType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Answer", inversedBy="answerModerations")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id")
     */
    private $answer;

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
     * @return RelModerationUserAnswer
     */
    public function setModerator($moderator)
    {
        $this->moderator = $moderator;
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
     * @return RelModerationUserAnswer
     */
    public function setModerationType($moderationType)
    {
        $this->moderationType = $moderationType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     * @return RelModerationUserAnswer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $this;
    }


}
