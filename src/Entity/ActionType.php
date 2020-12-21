<?php

namespace App\Entity;

use App\Repository\ActionTypeRepository;
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="RelUserActionResource", mappedBy="actionType")
     */
    private $resourceUsers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResourceUsers()
    {
        return $this->resourceUsers;
    }

    /**
     * @param mixed $resourceUsers
     */
    public function setResourceUsers($resourceUsers): void
    {
        $this->resourceUsers = $resourceUsers;
    }
}
