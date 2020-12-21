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
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ShareGroup", inversedBy="users")
     * @ORM\JoinColumn(name="share_group_id", referencedColumnName="id", nullable=false)
     *
     * @var ShareGroup
     */
    private $shareGroup;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shareGroups")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    private $user;

    public function getId(): int
    {
        return $this->id;
    }

    public function isCreator(): bool
    {
        return $this->creator;
    }

    public function setCreator(bool $creator): RelShareGroupUser
    {
        $this->creator = $creator;

        return $this;
    }

    public function getShareGroup(): ShareGroup
    {
        return $this->shareGroup;
    }

    public function setShareGroup(ShareGroup $shareGroup): RelShareGroupUser
    {
        $this->shareGroup = $shareGroup;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): RelShareGroupUser
    {
        $this->user = $user;

        return $this;
    }
}
