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
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ResourceRepository::class)
 * @Vich\Uploadable
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
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @Vich\UploadableField(mapping="res_img", fileNameProperty="imageName", size="imageSize")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string",nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer",nullable=true)
     *
     * @var int|null
     */
    private $imageSize;

    /**
     * @Vich\UploadableField(mapping="res_content", fileNameProperty="contentName", size="contentSize")
     *
     * @var File|null
     */
    private $contentFile;

    /**
     * @ORM\Column(type="string",nullable=true)
     *
     * @var string|null
     */
    private $contentName;

    /**
     * @ORM\Column(type="integer",nullable=true)
     *
     * @var int|null
     */
    private $contentSize;

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

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    private $valuation;

    private $shareNb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentary", mappedBy="resource")
     *
     * @var Collection
     */
    private $commentaries;

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
        $this->commentaries = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getDateCreation(): DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function getFormatedDateCreation(): string
    {
        return $this->dateCreation->format('d M Y H:i:s');
    }

    public function setDateCreation(DateTimeInterface $dateCreation): self
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

    public function getAgeCategory(): ?AgeCategory
    {
        return $this->ageCategory;
    }

    public function setAgeCategory(AgeCategory $ageCategory): self
    {
        $this->ageCategory = $ageCategory;

        return $this;
    }

    public function getUser(): ?User
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

    public function getResourceType(): ?ResourceType
    {
        return $this->resourceType;
    }

    public function setResourceType(ResourceType $resourceType): self
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    public function getRelationShip(): ?RelationshipType
    {
        return $this->relationShip;
    }

    public function setRelationShip(RelationshipType $relationShip): self
    {
        $this->relationShip = $relationShip;

        return $this;
    }

    public function getCategory(): ?Category
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValuation()
    {
        return $this->valuation;
    }

    /**
     * @param mixed $valuation
     */
    public function setValuation($valuation): void
    {
        $this->valuation = $valuation;
    }

    /**
     * @return mixed
     */
    public function getShareNb()
    {
        return $this->shareNb;
    }

    /**
     * @param mixed $shareNb
     */
    public function setShareNb($shareNb): void
    {
        $this->shareNb = $shareNb;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setContentFile(?File $contentFile = null): void
    {
        $this->contentFile = $contentFile;
    }

    public function getContentFile(): ?File
    {
        return $this->contentFile;
    }

    public function setContentName(?string $contentName): void
    {
        $this->contentName = $contentName;
    }

    public function getContentName(): ?string
    {
        return $this->contentName;
    }

    public function setContentSize(?int $contentSize): void
    {
        $this->contentSize = $contentSize;
    }

    public function getContentSize(): ?int
    {
        return $this->contentSize;
    }

    /**
     * @return Collection
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    /**
     * @param Collection $commentaries
     * @return Resource
     */
    public function setCommentaries(Collection $commentaries): Resource
    {
        $this->commentaries = $commentaries;
        return $this;
    }


}
