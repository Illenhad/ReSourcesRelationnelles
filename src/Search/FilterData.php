<?php


namespace App\Search;


use App\Entity\AgeCategory;
use App\Entity\RelationshipType;
use \App\Entity\ResourceType;

class FilterData
{
    /**
     * @var string|null
     */
    private $search;

    /**
     *@var  ResourceType[]|null
     */
    private $type;

    /**
     *@var  RelationshipType[]|null
     */
    private $relation;

    /**
     * @var AgeCategory[]|null
     */
    private $age;

    public function __construct()
    {
        $this->type=[];
        $this->relation=[];
        $this->age=[];
    }

    /**
     * @return ResourceType[]|null
     */
    public function getType(): ?array
    {
        return $this->type;
    }

    /**
     * @param ResourceType[] $type
     */
    public function setType(array $type): FilterData
    {
        $this->type =$type;
        return $this;
    }

    /**
     * @return RelationshipType[]|null
     */
    public function getRelation(): ?array
    {
        return $this->relation;
    }

    /**
     * @param RelationshipType[] $relation
     */
    public function setRelation(array $relation):  FilterData
    {
        $this->relation=$relation;
        return $this;
    }

    /**
     * @return AgeCategory[]|null
     */
    public function getAge(): ?array
    {
        return $this->age;
    }

    /**
     * @param AgeCategory $age
     */
    public function setAge(array $age): FilterData
    {
        $this->age=$age;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @param string|null $search
     */
    public function setSearch(?string $search): void
    {
        $this->search = $search;
    }

}