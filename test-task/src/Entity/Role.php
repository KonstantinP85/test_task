<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 * @ORM\Table(name="roles")
 */
class Role
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
     * @var Collection
     * @ORM\OneToMany(targetEntity=AccessMatrix::class, mappedBy="role")
     */
    private Collection $accesses;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
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
        $accessMatrix->setRole($this);
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