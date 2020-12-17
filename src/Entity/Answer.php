<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass=Answer::class)
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ManyToOne(targetEntity="App\Entity\Comment", inversedBy="answers")
     * @JoinColumn(name="comment_id", referencedColumnName="id")
     * @var Comment
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserAnswer", mappedBy="answer")
     */
    private $answerModerations;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ManyToOne(targetEntity="App\Entity\User", inversedBy="answers")
     * @JoinColumn(name="usert_id", referencedColumnName="id")
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     */
    private $answerDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Answer
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Comment
     */
    public function getComment(): Comment
    {
        return $this->comment;
    }

    /**
     * @param Comment $comment
     * @return Answer
     */
    public function setComment(Comment $comment): Answer
    {
        $this->comment = $comment;
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

    /**
     * @return mixed
     */
    public function getAnswerModerations()
    {
        return $this->answerModerations;
    }

    /**
     * @param mixed $answerModerations
     * @return Answer
     */
    public function setAnswerModerations($answerModerations)
    {
        $this->answerModerations = $answerModerations;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Answer
     */
    public function setUser(User $user): Answer
    {
        $this->user = $user;
        return $this;
    }

    public function getAnswerDate(): ?\DateTimeInterface
    {
        return $this->answerDate;
    }

    public function setAnswerDate(\DateTimeInterface $answerDate): self
    {
        $this->answerDate = $answerDate;

        return $this;
    }



}