<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\OneToMany(targetEntity="Resource", mappedBy="category")
     *
     * @var Collection
     */
    private $resources;

    public function __construct()
    {
        $this->resources = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Category
    {
        $this->label = $label;

        return $this;
    }

    public function getResources(): Collection
    {
        return $this->resources;
    }

    public function setResources(Collection $resources): Category
    {
        $this->resources = $resources;

        return $this;
    }

    public function __toString(): string
    {
        return $this->label;
    }
}
