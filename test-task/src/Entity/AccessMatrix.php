<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccessMatrixRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=AccessMatrixRepository::class)
 * @ORM\Table(name="access_matrix")
 */
class AccessMatrix
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid")
     */
    private string $id;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="accecces")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Role $role;

    /**
     * @var Action
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="accecces")
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Action $action;

    /**
     * @var ObjectClass
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="accecces")
     * @ORM\JoinColumn(name="object_class_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private ObjectClass $objectClass;

    /**
     * @param Role $role
     * @param Action $action
     * @param ObjectClass $objectClass
     */
    public function __construct(Role $role, Action $action, ObjectClass $objectClass)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->role = $role;
        $role->addAccessMatrix($this);
        $this->action = $action;
        $action->addAccessMatrix($this);
        $this->objectClass = $objectClass;
        $objectClass->addAccessMatrix($this);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     */
    public function setRole(Role $role): void
    {
        if ($this->role === $role) {
            return;
        }

        $this->role = $role;
        $role->addAccessMatrix($this);
    }

    /**
     * @return Action
     */
    public function getAction(): Action
    {
        return $this->action;
    }

    /**
     * @param Action $action
     */
    public function setAction(Action $action): void
    {
        if ($this->action === $action) {
            return;
        }

        $this->action = $action;
        $action->addAccessMatrix($this);
    }

    /**
     * @return ObjectClass
     */
    public function getObjectClass(): ObjectClass
    {
        return $this->objectClass;
    }

    /**
     * @param ObjectClass $objectClass
     */
    public function setObjectClass(ObjectClass $objectClass): void
    {
        if ($this->objectClass === $objectClass) {
            return;
        }

        $this->objectClass = $objectClass;
        $objectClass->addAccessMatrix($this);
    }
}