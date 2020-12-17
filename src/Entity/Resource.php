<?php

namespace App\Entity;

use App\Repository\ResourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

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
     * @ORM\OneToMany(targetEntity="RelModerationUserResource", mappedBy="resource")
     */
    private $resourceModerations;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AgeCategory", inversedBy="resources")
     * @ORM\JoinColumn(name="age_category_id", referencedColumnName="id")
     */
    private $ageCategory;

    /**
     * @ManyToOne(targetEntity="App\Entity\User", inversedBy="resources")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    // ...

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="resource")
     */
    private $comments;

    /**
     * @ManyToOne(targetEntity="App\Entity\ResourceType", inversedBy="resources")
     * @JoinColumn(name="resource_type_id", referencedColumnName="id")
     *
     * @var ResourceType
     */
    private $resourceType;

    /**
     * @ManyToOne(targetEntity="App\Entity\RelationShipType", inversedBy="resources")
     * @JoinColumn(name="relation_ship_type_id", referencedColumnName="id")
     *
     * @var RelationshipType
     */
    private $relationShip;

    /**
     * @ManyToOne(targetEntity="App\Entity\Category", inversedBy="resources")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     *
     * @var Category
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RelSharedResourceUser", mappedBy="resource")
     */
    private $sharedResources;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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

    /**
     * @return mixed
     */
    public function getAgeCategory()
    {
        return $this->ageCategory;
    }

    /**
     * @param mixed $ageCategory
     * @return Resource
     */
    public function setAgeCategory($ageCategory)
    {
        $this->ageCategory = $ageCategory;
        return $this;
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
     * @return Resource
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return ResourceType
     */
    public function getResourceType(): ResourceType
    {
        return $this->resourceType;
    }

    /**
     * @param ResourceType $resourceType
     * @return Resource
     */
    public function setResourceType(ResourceType $resourceType): Resource
    {
        $this->resourceType = $resourceType;
        return $this;
    }

    /**
     * @return RelationshipType
     */
    public function getRelationShip(): RelationshipType
    {
        return $this->relationShip;
    }

    /**
     * @param RelationshipType $relationShip
     * @return Resource
     */
    public function setRelationShip(RelationshipType $relationShip): Resource
    {
        $this->relationShip = $relationShip;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Resource
     */
    public function setCategory(Category $category): Resource
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSharedResources()
    {
        return $this->sharedResources;
    }

    /**
     * @param mixed $sharedResources
     * @return Resource
     */
    public function setSharedResources($sharedResources)
    {
        $this->sharedResources = $sharedResources;
        return $this;
    }


}
