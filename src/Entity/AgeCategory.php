<?php

namespace App\Entity;

use App\Repository\AgeCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use phpDocumentor\Reflection\Types\Collection;

/**
 * @ORM\Entity(repositoryClass=AgeCategoryRepository::class)
 */
class AgeCategory
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
     * @OneToMany(targetEntity="App\Entity\User", mappedBy="ageCategory")
     *
     * @var Collection
     */
    private $users;

    /**
     * @OneToMany(targetEntity="App\Entity\Resource", mappedBy="ageCategory")
     *
     * @var Collection
     */
    private $resources;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->resources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): AgeCategory
    {
        $this->label = $label;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): AgeCategory
    {
        $this->users = $users;

        return $this;
    }

    public function getResources(): Collection
    {
        return $this->resources;
    }

    public function setResources(Collection $resources): AgeCategory
    {
        $this->resources = $resources;

        return $this;
    }

    public function __toString(): string
    {
        return $this->label;
    }
}
