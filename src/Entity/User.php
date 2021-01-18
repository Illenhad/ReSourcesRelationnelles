<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *  * @UniqueEntity("username")
 *  * @UniqueEntity("email")
 */
class User implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTimeInterface
     */
    private $dateLastConnection;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="users")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=false)
     *
     * @var Department
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=True)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit comporter au moins 8 caractères.")
     *
     * @var string
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Votre mot de passe doit être le même que celui que vous confirmez")
     */
    private $confirmPassword;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AgeCategory", inversedBy="users")
     * @ORM\JoinColumn(name="age_category_id", referencedColumnName="id")
     *
     * @var AgeCategory
     */
    private $ageCategory;

    /**
     * @ORM\OneToMany(targetEntity="RelShareGroupUser", mappedBy="user")
     *
     * @var Collection
     */
    private $shareGroups;

    /**
     * @ORM\OneToMany(targetEntity="RelUserManagementResource", mappedBy="user")
     *
     * @var Collection
     */
    private $resourceManagements;

    /**
     * @ORM\OneToMany(targetEntity="RelUserActionResource", mappedBy="user")
     *
     * @var Collection
     */
    private $resourceActions;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     *
     * @var Collection
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUser", mappedBy="user")
     *
     * @var Collection
     */
    private $userModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUser", mappedBy="moderator")
     *
     * @var Collection
     */
    private $moderatorModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserComment", mappedBy="moderator")
     *
     * @var Collection
     */
    private $commentModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserResource", mappedBy="moderator")
     *
     * @var Collection
     */
    private $resourceModerations;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="user")
     *
     * @var Collection
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Resource", mappedBy="user")
     *
     * @var Collection
     */
    private $resources;

    /**
     * @ORM\OneToMany(targetEntity="RelSharedResourceUser", mappedBy="sharerUser")
     *
     * @var Collection
     */
    private $sharerUsers;

    /**
     * @ORM\OneToMany(targetEntity="RelSharedResourceUser", mappedBy="sharedWithUser")
     *
     * @var Collection
     */
    private $sharedWithUsers;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserAnswer", mappedBy="moderator")
     *
     * @var Collection
     */
    private $answerModerations;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $token_recup;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="date")
     */
    private $creationDate;

    public function __construct()
    {
        $this->dateLastConnection = new DateTime('NOW');
        $this->resources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateLastConnection(): string
    {
        return $this->dateLastConnection->format('d M Y H:i:s');
    }

    public function setDateLastConnection(DateTimeInterface $dateLastConnection): self
    {
        $this->dateLastConnection = $dateLastConnection;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    public function setDepartment(Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    /**
     * @return mixed
     *
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    //Fonction neccessaire pour ID

    /**
     * @see UserInterface
     */
    public function getSalt(): string
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return $this->username;
    }

    //Fonction neccessaire pour ID

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    //Fonction neccessaire pour ID

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = [];
        $roles[0] = $this->getRole()->getLabel();

        return $roles;
    }

    /**
     * @param mixed $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     *
     * @return User
     */
    public function setRoles($role)
    {
        $this->role = $role;

        return $this;
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
     *
     * @return User
     */
    public function setAgeCategory($ageCategory)
    {
        $this->ageCategory = $ageCategory;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShareGroups()
    {
        return $this->shareGroups;
    }

    /**
     * @param mixed $shareGroups
     */
    public function setShareGroups($shareGroups): void
    {
        $this->shareGroups = $shareGroups;
    }

    /**
     * @return mixed
     */
    public function getResourceManagements()
    {
        return $this->resourceManagements;
    }

    /**
     * @param mixed $resourceManagements
     */
    public function setResourceManagements($resourceManagements): void
    {
        $this->resourceManagements = $resourceManagements;
    }

    /**
     * @return mixed
     */
    public function getResourceActions()
    {
        return $this->resourceActions;
    }

    /**
     * @param mixed $resourceActions
     */
    public function setResourceActions($resourceActions): void
    {
        $this->resourceActions = $resourceActions;
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
    public function getModeratorModerations()
    {
        return $this->moderatorModerations;
    }

    /**
     * @param mixed $moderatorModerations
     */
    public function setModeratorModerations($moderatorModerations): void
    {
        $this->moderatorModerations = $moderatorModerations;
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

    public function getResources()
    {
        return $this->resources;
    }

    public function setResources(Resource $resources): User
    {
        $this->resources = $resources;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSharerUsers()
    {
        return $this->sharerUsers;
    }

    /**
     * @param mixed $sharerUsers
     *
     * @return User
     */
    public function setSharerUsers($sharerUsers)
    {
        $this->sharerUsers = $sharerUsers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSharedWithUsers()
    {
        return $this->sharedWithUsers;
    }

    /**
     * @param mixed $sharedWithUsers
     *
     * @return User
     */
    public function setSharedWithUsers($sharedWithUsers)
    {
        $this->sharedWithUsers = $sharedWithUsers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswerModerations()
    {
        return $this->answerModerations;
    }

    /**
     * @param mixed $answerModerations
     *
     * @return User
     */
    public function setAnswerModerations($answerModerations)
    {
        $this->answerModerations = $answerModerations;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $answers
     *
     * @return User
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    public function getTokenRecup(): ?string
    {
        return $this->token_recup;
    }

    public function setTokenRecup(?string $token_recup): self
    {
        $this->token_recup = $token_recup;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreationDate(): ?DateTimeInterface
    {
        return $this->creationDate;
    }

    public function getFormatedCreationDate(): string
    {
        return $this->creationDate->format('d M Y H:i:s');
    }

    public function setCreationDate(DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }
}
