<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Collection;

/**
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 */
class Department
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
     * Correspond aux deux premiers chiffres du code postal.
     *
     * @ORM\Column(type="string", length=3)
     *
     * @var string
     */
    private $number;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="department")
     *
     * @var Collection
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Department
    {
        $this->label = $label;

        return $this;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): Department
    {
        $this->number = $number;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): Department
    {
        $this->users = $users;

        return $this;
    }

    public function __toString(): string
    {
        return $this->label;
    }
}
