<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\AccessMatrix;
use App\Repository\AccessMatrixRepository;
use Doctrine\ORM\EntityManagerInterface;

class AccessMatrixManager
{
    /**
     * @var ActionManager
     */
    private ActionManager $actionManager;

    /**
     * @var RoleManager
     */
    private RoleManager $roleManager;

    /**
     * @var ObjectClassManager
     */
    private ObjectClassManager $objectClassManager;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var AccessMatrixRepository
     */
    private AccessMatrixRepository $accessMatrixRepository;

    /**
     * @var WorkTypeManager
     */
    private WorkTypeManager $workTypeManager;

    /**
     * @param ActionManager $actionManager
     * @param RoleManager $roleManager
     * @param ObjectClassManager $objectClassManager
     * @param EntityManagerInterface $entityManager
     * @param AccessMatrixRepository $accessMatrixRepository
     * @param WorkTypeManager $workTypeManager
     */
    public function __construct(
        ActionManager $actionManager,
        RoleManager $roleManager,
        ObjectClassManager $objectClassManager,
        EntityManagerInterface $entityManager,
        AccessMatrixRepository $accessMatrixRepository,
        WorkTypeManager $workTypeManager
    ) {
        $this->actionManager = $actionManager;
        $this->roleManager = $roleManager;
        $this->objectClassManager = $objectClassManager;
        $this->entityManager = $entityManager;
        $this->accessMatrixRepository = $accessMatrixRepository;
        $this->workTypeManager = $workTypeManager;
    }

    /**
     * @param array $arguments
     * @throws \Exception
     */
    public function create(array $arguments): void
    {
        $role = $this->roleManager->get($arguments['role']);
        $action = $this->actionManager->get($arguments['action']);
        if ($arguments['object'] === 'work_type') {
            $objectClassId = $this->objectClassManager->getBySourceName($arguments['object']);
        } else {
            $objectClassId = $this->objectClassManager->get($arguments['object']);
        }
        if ($arguments['oId'] !== "") {
            $objectId = $this->workTypeManager->get($arguments['oId']);
            $accessMatrix = new AccessMatrix($role, $action, $objectClassId, $objectId->getId());
        } else {
            $accessMatrix = new AccessMatrix($role, $action, $objectClassId);
        }
        $this->entityManager->persist($accessMatrix);
        $this->entityManager->flush();
    }

    /**
     * @param array $arguments
     * @throws \Exception
     */
    public function delete(array $arguments): void
    {
        $role = $this->roleManager->get($arguments['role']);
        $action = $this->actionManager->get($arguments['action']);
        $object = $this->objectClassManager->get($arguments['object']);
        $accessMatrix = $this->accessMatrixRepository->findOneBy([
            'role' => $role,
            'action' => $action,
            'objectClass' => $object
        ]);
        $this->entityManager->remove($accessMatrix);
        $this->entityManager->flush();
    }

    /**
     * @return array
     */
    public function getAllAccessMatrix(): array
    {
        return $this->accessMatrixRepository->findAll();
    }

    /**
     * @param string $roleId
     * @return array|AccessMatrix[]
     */
    public function getByRole(string $roleId): array
    {
        return $this->accessMatrixRepository->findBy(['role' => $roleId]);
    }
}