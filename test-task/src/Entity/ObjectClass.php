<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ObjectClassRepository::class)
 * @ORM\Table(name="object_class")
 */
class ObjectClass
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid")
     */
    private string $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private string $name;

    /**
     * @var string
     * @ORM\Column(name="source_name", type="string")
     */
    private string $sourceName;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity=AccessMatrix::class, mappedBy="objectClass")
     */
    private Collection $accesses;

    /**
     *
     */
    public function __construct(string $name, string $sourceName)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
        $this->sourceName = $sourceName;
        $this->accesses = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSourceName(): string
    {
        return $this->sourceName;
    }

    /**
     * @param string $sourceName
     */
    public function setSourceName(string $sourceName): void
    {
        $this->sourceName = $sourceName;
    }

    /**
     * @return Collection|AccessMatrix[]
     */
    public function getAccesses(): Collection
    {
        return $this->accesses;
    }

    /**
     * @param AccessMatrix $accessMatrix
     */
    public function addAccessMatrix(AccessMatrix $accessMatrix): void
    {
        if ($this->accesses->contains($accessMatrix)) {
            return;
        }

        $this->accesses->add($accessMatrix);
        $accessMatrix->setObjectClass($this);
    }

    /**
     * @param AccessMatrix $accessMatrix
     */
    public function removeAccessMatrix(AccessMatrix $accessMatrix): void
    {
        if (!$this->accesses->contains($accessMatrix)) {
            return;
        }

        $this->accesses->removeElement($accessMatrix);
    }
}