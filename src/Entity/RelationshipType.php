<?php

namespace App\Entity;

use App\Repository\RelationshipTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelationshipTypeRepository::class)
 */
class RelationshipType
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

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return RelationshipType
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

}
