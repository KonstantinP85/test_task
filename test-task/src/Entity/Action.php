<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 * @ORM\Table(name="actions")
 */
class Action
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
     * @ORM\Column(name="signature", type="string")
     */
    private string $signature;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity=AccessMatrix::class, mappedBy="action")
     */
    private Collection $accesses;

    /**
     *
     */
    public function __construct(string $name, string $signature)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
        $this->signature = $signature;
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
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     */
    public function setSignature(string $signature): void
    {
        $this->signature = $signature;
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
        $accessMatrix->setAction($this);
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