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


}