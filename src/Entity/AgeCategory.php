<?php

namespace App\Entity;

use App\Repository\AgeCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity(repositoryClass=AgeCategoryRepository::class)
 */
class AgeCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
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
     */
    private $users;

    /**
     * @OneToMany(targetEntity="App\Entity\Resource", mappedBy="ageCategory")
     */
    private $resources;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->resources = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
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

    public function __toString(): string
    {
        return $this->label;
    }
}
