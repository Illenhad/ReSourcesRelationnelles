<?php

namespace App\Entity;

use App\Repository\ResourceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResourceRepository::class)
 */
class Resource
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\OneToMany(targetEntity="RelUserManagementResource", mappedBy="resource")
     */
    private $userManagement;

    /**
     * @ORM\OneToMany(targetEntity="RelUserActionResource", mappedBy="resource")
     */
    private $userActions;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="resource")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserResource", mappedBy="resource")
     */
    private $resourceModerations;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }


    public function getDateCreation()
    {
        return $this->dateCreation;
    }


    public function setDateCreation($dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return mixed
     */
    public function getUserManagement()
    {
        return $this->userManagement;
    }

    /**
     * @param mixed $userManagement
     */
    public function setUserManagement($userManagement): void
    {
        $this->userManagement = $userManagement;
    }

    /**
     * @return mixed
     */
    public function getUserActions()
    {
        return $this->userActions;
    }

    /**
     * @param mixed $userActions
     */
    public function setUserActions($userActions): void
    {
        $this->userActions = $userActions;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getResourceModerations()
    {
        return $this->resourceModerations;
    }

    /**
     * @param mixed $resourceModerations
     */
    public function setResourceModerations($resourceModerations): void
    {
        $this->resourceModerations = $resourceModerations;
    }


}
