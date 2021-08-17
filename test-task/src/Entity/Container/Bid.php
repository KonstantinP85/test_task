<?php

declare(strict_types=1);

namespace App\Entity\Container;

use App\Repository\Container\BidRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=BidRepository::class)
 * @ORM\Table(name="bid")
 */
class Bid
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid")
     */
    private string $id;

    /**
     * @var string|null
     * @ORM\Column(name="parent_id", type="string", nullable=true)
     */
    private ?string $parentId;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private string $name;

    /**
     * @param string $parentId
     * @param string $name
     */
    public function __construct(string $parentId, string $name)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->parentId = $parentId;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    /**
     * @param string|null $parentId
     */
    public function setParentId(?string $parentId): void
    {
        $this->parentId = $parentId;
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
}