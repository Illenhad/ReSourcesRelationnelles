<?php

namespace App\Entity;

use App\Repository\RelShareGroupUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelShareGroupUserRepository::class)
 */
class RelShareGroupUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ShareGroup", inversedBy="users")
     * @ORM\JoinColumn(name="share_group_id", referencedColumnName="id", nullable=false)
     */
    private $shareGroup;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shareGroups")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreator(): ?bool
    {
        return $this->creator;
    }

    public function setCreator(bool $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShareGroup()
    {
        return $this->shareGroup;
    }

    /**
     * @param mixed $shareGroup
     */
    public function setShareGroup($shareGroup): void
    {
        $this->shareGroup = $shareGroup;
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
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

}
