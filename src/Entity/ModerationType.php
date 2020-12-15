<?php

namespace App\Entity;

use App\Repository\ModerationTypeRepository;
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUser", mappedBy="moderationType")
     */
    private $userModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserComment", mappedBy="moderationType")
     */
    private $commentModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserResource", mappedBy="moderationType")
     */
    private $resourceModeration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserModerations()
    {
        return $this->userModerations;
    }

    /**
     * @param mixed $userModerations
     */
    public function setUserModerations($userModerations): void
    {
        $this->userModerations = $userModerations;
    }

    /**
     * @return mixed
     */
    public function getCommentModerations()
    {
        return $this->commentModerations;
    }

    /**
     * @param mixed $commentModerations
     */
    public function setCommentModerations($commentModerations): void
    {
        $this->commentModerations = $commentModerations;
    }

    /**
     * @return mixed
     */
    public function getResourceModeration()
    {
        return $this->resourceModeration;
    }

    /**
     * @param mixed $resourceModeration
     */
    public function setResourceModeration($resourceModeration): void
    {
        $this->resourceModeration = $resourceModeration;
    }


}
