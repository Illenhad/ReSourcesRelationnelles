<?php

namespace App\Entity;

use App\Repository\ShareGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Collection;

/**
 * @ORM\Entity(repositoryClass=ShareGroupRepository::class)
 */
class ShareGroup
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
    private $label;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RelShareGroupUser", mappedBy="shareGroup")
     *
     * @var Collection
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): ShareGroup
    {
        $this->label = $label;

        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): ShareGroup
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): ShareGroup
    {
        $this->users = $users;

        return $this;
    }
}
