<?php

namespace App\Entity;

use App\Repository\ActionTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActionTypeRepository::class)
 */
class ActionType
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
     * @ORM\OneToMany(targetEntity="RelUserActionResource", mappedBy="actionType")
     *
     * @var Collection
     */
    private $resourceUsers;

    public function __construct()
    {
        $this->resourceUsers = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): ActionType
    {
        $this->label = $label;

        return $this;
    }

    public function getResourceUsers(): Collection
    {
        return $this->resourceUsers;
    }

    public function setResourceUsers(Collection $resourceUsers): ActionType
    {
        $this->resourceUsers = $resourceUsers;

        return $this;
    }
}
