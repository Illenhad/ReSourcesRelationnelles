<?php

namespace App\Entity;

use App\Repository\ResourceRepository;
use Cocur\Slugify\Slugify;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $link;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $public;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface
     */
    private $dateCreation;

    /**
     * @ORM\OneToMany(targetEntity="RelUserManagementResource", mappedBy="resource")
     *
     * @var Collection
     */
    private $userManagements;

    /**
     * @ORM\OneToMany(targetEntity="RelUserActionResource", mappedBy="resource")
     *
     * @var Collection
     */
    private $userActions;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserResource", mappedBy="resource")
     *
     * @var Collection
     */
    private $resourceModerations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AgeCategory", inversedBy="resources")
     * @ORM\JoinColumn(name="age_category_id", referencedColumnName="id")
     *
     * @var AgeCategory
     */
    private $ageCategory;

    /**
     * @ManyToOne(targetEntity="App\Entity\User", inversedBy="resources")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="resource")
     *
     * @var Collection
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
     * @ManyToOne(targetEntity="App\Entity\RelationshipType", inversedBy="resources")
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
     *
     * @var Collection
     */
    private $sharedResources;

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->userManagements = new ArrayCollection();
        $this->userActions = new ArrayCollection();
        $this->resourceModerations = new ArrayCollection();
        $this->sharedResources = new ArrayCollection();
        $this->dateCreation = new DateTime('NOW');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function getFormatedDateCreation(): string
    {
        return $this->dateCreation->format('d M Y H:i:s');
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getUserManagements(): Collection
    {
        return $this->userManagements;
    }

    public function setUserManagements(Collection $userManagements): self
    {
        $this->userManagements = $userManagements;

        return $this;
    }

    public function getUserActions(): Collection
    {
        return $this->userActions;
    }

    public function setUserActions(Collection $userActions): self
    {
        $this->userActions = $userActions;

        return $this;
    }

    public function getResourceModerations(): Collection
    {
        return $this->resourceModerations;
    }

    public function setResourceModerations(Collection $resourceModerations): self
    {
        $this->resourceModerations = $resourceModerations;

        return $this;
    }

    public function getAgeCategory(): AgeCategory
    {
        return $this->ageCategory;
    }

    public function setAgeCategory(AgeCategory $ageCategory): self
    {
        $this->ageCategory = $ageCategory;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function setComments(Collection $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getResourceType(): ResourceType
    {
        return $this->resourceType;
    }

    public function setResourceType(ResourceType $resourceType): self
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    public function getRelationShip(): RelationshipType
    {
        return $this->relationShip;
    }

    public function setRelationShip(RelationshipType $relationShip): self
    {
        $this->relationShip = $relationShip;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSharedResources(): Collection
    {
        return $this->sharedResources;
    }

    public function setSharedResources(Collection $sharedResources): self
    {
        $this->sharedResources = $sharedResources;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
