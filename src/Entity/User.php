<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *  * @UniqueEntity("username")
 *  * @UniqueEntity("email")
 *
 */
class User implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLastConnection;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="users")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=false)
     * @var Collection
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     * @var Collection
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255, nullable=True)
     * @Assert\Length(min="8",minMessage="Votre mot de passe doit comporter au moins 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password",message="Votre mot de passe doit être le même que celui que vous confirmez")
     */
    private $confirm_password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AgeCategory", inversedBy="users")
     * @ORM\JoinColumn(name="age_category_id", referencedColumnName="id")
     */
    private $ageCategory;

    /**
     * @ORM\OneToMany(targetEntity="RelShareGroupUser", mappedBy="user")
     */
    private $shareGroups;

    /**
     * @ORM\OneToMany(targetEntity="RelUserManagementResource", mappedBy="user")
     */
    private $resourceManagements;

    /**
     * @ORM\OneToMany(targetEntity="RelUserActionResource", mappedBy="user")
     */
    private $resourceActions;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUser", mappedBy="user")
     */
    private $userModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUser", mappedBy="moderator")
     */
    private $moderatorModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserComment", mappedBy="moderator")
     */
    private $commentModerations;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserResource", mappedBy="moderator")
     */
    private $resourceModerations;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="user")
     */
    private $answers;


    /**
     * @OneToMany(targetEntity="App\Entity\Resource", mappedBy="user")
     *
     * @var Resource
     */
    private $resources ;
    // ...

    /**
     * @ORM\OneToMany(targetEntity="RelSharedResourceUser", mappedBy="sharerUser")
     */
    private $sharerUsers;

    /**
     * @ORM\OneToMany(targetEntity="RelSharedResourceUser", mappedBy="sharedWithUser")
     */
    private $sharedWithUsers;

    /**
     * @ORM\OneToMany(targetEntity="RelModerationUserAnswer", mappedBy="moderator")
     */
    private $answerModerations;

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
        return $this->dateLastConnection->format("d M Y H:i:s");
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
        return $this->confirm_password;
    }

    /**
     * @param mixed $confirm_password
     */
    public function setConfirmPassword($confirm_password): void
    {
        $this->confirm_password = $confirm_password;
    }

    /**
     * @return mixed
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    #Fonction neccessaire pour ID

    /**
     * @see UserInterface
     */
    public function getSalt(): string
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return $this->username;
    }

    #Fonction neccessaire pour ID

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    #Fonction neccessaire pour ID

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     *
     * @return $this
     */
    public function setRoles($roles): self
    {
        $this->roles = $roles;

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

    /**
     * @return Resource
     */
    public function getResources(): Resource
    {
        return $this->resources;
    }

    /**
     * @param Resource $resources
     * @return User
     */
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
     * @return User
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
        return $this;
    }


}
