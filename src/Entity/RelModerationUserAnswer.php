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
     * @var
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="answerModerations")
     * @ORM\JoinColumn(name="moderator_id", referencedColumnName="id")
     *
     * @var User
     */
    private $moderator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModerationType", inversedBy="answerModerations")
     * @ORM\JoinColumn(name="moderation_id", referencedColumnName="id")
     *
     * @var ModerationType
     */
    private $moderationType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Answer", inversedBy="relModerationUserAnswer")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id")
     *
     * @var Answer
     */
    private $answer;

    public function getId(): int
    {
        return $this->id;
    }

    public function getModerationDate(): \DateTimeInterface
    {
        return $this->moderationDate;
    }

    public function setModerationDate(\DateTimeInterface $moderationDate): RelModerationUserAnswer
    {
        $this->moderationDate = $moderationDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     *
     * @return RelModerationUserAnswer
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    public function getModerator(): User
    {
        return $this->moderator;
    }

    public function setModerator(User $moderator): RelModerationUserAnswer
    {
        $this->moderator = $moderator;

        return $this;
    }

    public function getModerationType(): ModerationType
    {
        return $this->moderationType;
    }

    public function setModerationType(ModerationType $moderationType): RelModerationUserAnswer
    {
        $this->moderationType = $moderationType;

        return $this;
    }

    public function getAnswer(): Answer
    {
        return $this->answer;
    }

    public function setAnswer(Answer $answer): RelModerationUserAnswer
    {
        $this->answer = $answer;

        return $this;
    }
}
