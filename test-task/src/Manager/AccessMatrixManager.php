<?php

declare(strict_types=1);

namespace App\Manager;

use App\DataProvider\ContainerDataProvider;
use App\Entity\AccessMatrix;
use App\Entity\Action;
use App\Entity\ObjectClass;
use App\Entity\Role;
use App\Repository\AccessMatrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Manager\Container\BidManager;
use App\Manager\Container\WorksCtoManager;
use App\Manager\Container\WorkTypeManager;

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
     * @var BidManager
     */
    private BidManager $bidManager;

    /**
     * @var WorksCtoManager
     */
    private WorksCtoManager $worksCtoManager;

    /**
     * @param ActionManager $actionManager
     * @param RoleManager $roleManager
     * @param ObjectClassManager $objectClassManager
     * @param EntityManagerInterface $entityManager
     * @param AccessMatrixRepository $accessMatrixRepository
     * @param WorkTypeManager $workTypeManager
     * @param BidManager $bidManager
     * @param WorksCtoManager $worksCtoManager
     */
    public function __construct(
        ActionManager $actionManager,
        RoleManager $roleManager,
        ObjectClassManager $objectClassManager,
        EntityManagerInterface $entityManager,
        AccessMatrixRepository $accessMatrixRepository,
        WorkTypeManager $workTypeManager,
        BidManager $bidManager,
        WorksCtoManager $worksCtoManager
    ) {
        $this->actionManager = $actionManager;
        $this->roleManager = $roleManager;
        $this->objectClassManager = $objectClassManager;
        $this->entityManager = $entityManager;
        $this->accessMatrixRepository = $accessMatrixRepository;
        $this->workTypeManager = $workTypeManager;
        $this->bidManager = $bidManager;
        $this->worksCtoManager = $worksCtoManager;
    }

    /**
     * @param array $arguments
     * @throws \Exception
     */
    public function create(array $arguments): void
    {
        $role = $this->roleManager->get($arguments['role']);
        $action = $this->actionManager->get($arguments['action']);
        if (ContainerDataProvider::isContainer($arguments['object'])) {
            $objectClassId = $this->objectClassManager->getBySourceName($arguments['object']);
        } else {
            $objectClassId = $this->objectClassManager->get($arguments['object']);
        }
        if ($arguments['oId'] !== "" && !ContainerDataProvider::isContainer($arguments['oId'])) {
            $manager = $this->initManager($arguments['object']) . "Manager";
            $objectId = $this->{$manager}->get($arguments['oId']);
            $this->recursive($objectId, $role, $action, $objectClassId);
        } elseif (!ContainerDataProvider::isContainer($arguments['oId'])) {
            $accessMatrix = new AccessMatrix($role, $action, $objectClassId);
            $this->entityManager->persist($accessMatrix);
            $this->entityManager->flush();
        }
        if (ContainerDataProvider::isContainer($arguments['oId'])) {
            //главная, контейнеры
            $container = $this->{$this->initManager($arguments['oId']) . "Manager"}->getAll();
            foreach ($container as $element) {
                $this->recursive($element, $role, $action, $objectClassId);
            }
        }
    }

    /**
     * @param $element
     * @param Role $role
     * @param Action $action
     * @param ObjectClass $objectClassId
     */
    public function recursive($element, Role $role, Action $action, ObjectClass $objectClassId): void
    {
        if ($element->getParentId() !== null) {
            $accessMatrix = new AccessMatrix($role, $action, $objectClassId, $element->getId());
            $this->entityManager->persist($accessMatrix);
            $this->entityManager->flush();
            foreach ($this->{$this->initManager($element->getParentId()) . "Manager"}->getAll() as $el) {
                echo $el->getName();
                $this->recursive($el, $role, $action, $objectClassId);
            }
        } else {
            $accessMatrix = new AccessMatrix($role, $action, $objectClassId, $element->getId());
            $this->entityManager->persist($accessMatrix);
            $this->entityManager->flush();
        }
    }

    /**
     * @param array $arguments
     * @throws \Exception
     */
    public function delete(array $arguments): void
    {
        $role = $this->roleManager->get($arguments['role']);
        $action = $this->actionManager->get($arguments['action']);
        if ($arguments['oId'] === "") { echo 90;
            $object = $this->objectClassManager->get($arguments['object']);
            $accessMatrix = $this->accessMatrixRepository->findOneBy([
                'role' => $role,
                'action' => $action,
                'objectClass' => $object
            ]);
        } elseif (!ContainerDataProvider::isContainer($arguments['oId'])) { echo 89;
            $accessMatrix = $this->accessMatrixRepository->findOneBy([
                'role' => $role,
                'action' => $action,
                'objectId' => $arguments['oId'],
            ]);
        }
        if (ContainerDataProvider::isContainer($arguments['oId'])) {
            $object = $this->objectClassManager->get($arguments['object']);
            $accessMatrixWorkType = $this->accessMatrixRepository->findBy([
                'role' => $role,
                'action' => $action,
                'objectClass' => $object
            ]);
            foreach ($accessMatrixWorkType as $accessMatrix) {
                $this->entityManager->remove($accessMatrix);
                $this->entityManager->flush();
            }
        } else {
            $this->entityManager->remove($accessMatrix);
            $this->entityManager->flush();
        }
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

    /**
     * @param string $roleId
     * @return array
     */
    public function toArray(string $roleId): array
    {
        $result = [];
        $accessesMatrixByRole = $this->getByRole($roleId);
        foreach ($accessesMatrixByRole as $accessMatrix) {
            $result[] = [
                'id' => $accessMatrix->getId(),
                'role' => $accessMatrix->getRole()->getId(),
                'action' => $accessMatrix->getAction()->getId(),
                'objectClass' => $accessMatrix->getObjectClass()->getId(),
                'objectId' => $accessMatrix->getObjectId(),
            ];
        }

        return $result;
    }

    /**
     * @param string $key
     * @return string
     */
    private function initManager(string $key): string
    {
        if (strpos($key, '_') !== false) {

            $arr = explode("_", $key);

            $result = $arr[0] . ucfirst($arr[1]);

        } else {
            $result = $key;
        }

        return $result;
    }
}