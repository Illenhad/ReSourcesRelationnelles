<?php

namespace App\Entity;

use App\Repository\ModerationTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModerationTypeRepository::class)
 */
class ModerationType
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
     * @ORM\OneToMany(targetEntity="RelModerationUser", mappedBy="moderationType")
     *
     * @var Collection
     */
    private $userModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserComment", mappedBy="moderationType")
     *
     * @var Collection
     */
    private $commentModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserResource", mappedBy="moderationType")
     *
     * @var Collection
     */
    private $resourceModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserAnswer", mappedBy="moderationType")
     *
     * @var Collection
     */
    private $answerModerations;

    public function __construct()
    {
        $this->userModerations = new ArrayCollection();
        $this->commentModerations = new ArrayCollection();
        $this->resourceModerations = new ArrayCollection();
        $this->answerModerations = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): ModerationType
    {
        $this->label = $label;

        return $this;
    }

    public function getUserModerations(): Collection
    {
        return $this->userModerations;
    }

    public function setUserModerations(Collection $userModerations): ModerationType
    {
        $this->userModerations = $userModerations;

        return $this;
    }

    public function getCommentModerations(): Collection
    {
        return $this->commentModerations;
    }

    public function setCommentModerations(Collection $commentModerations): ModerationType
    {
        $this->commentModerations = $commentModerations;

        return $this;
    }

    public function getResourceModerations(): Collection
    {
        return $this->resourceModerations;
    }

    public function setResourceModerations(Collection $resourceModerations): ModerationType
    {
        $this->resourceModerations = $resourceModerations;

        return $this;
    }

    public function getAnswerModerations(): Collection
    {
        return $this->answerModerations;
    }

    public function setAnswerModerations(Collection $answerModerations): ModerationType
    {
        $this->answerModerations = $answerModerations;

        return $this;
    }
}
