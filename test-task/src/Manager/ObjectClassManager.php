<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\ObjectClass;
use App\Repository\ObjectClassRepository;

class ObjectClassManager
{
    /**
     * @var ObjectClassRepository
     */
    private ObjectClassRepository $objectClassRepository;

    /**
     * @param ObjectClassRepository $objectClassRepository
     */
    public function __construct(ObjectClassRepository $objectClassRepository)
    {
        $this->objectClassRepository = $objectClassRepository;
    }

    /**
     * @return array|ObjectClass[]
     */
    public function getAllObjectClass(): array
    {
        return $this->objectClassRepository->findAll();
    }

    /**
     * @param $id
     * @return ObjectClass
     * @throws \Exception
     */
    public function get($id): ObjectClass
    {
        $objectClass = $this->objectClassRepository->find($id);
        if (!$objectClass instanceof ObjectClass) {
            throw new \Exception("Invalid object class id");
        }

        return $objectClass;
    }

    /**
     * @param string $sourceName
     * @return ObjectClass
     * @throws \Exception
     */
    public function getBySourceName(string $sourceName): ObjectClass
    {
        $objectClass = $this->objectClassRepository->findOneBy(['sourceName' => $sourceName]);
        if (!$objectClass instanceof ObjectClass) {
            throw new \Exception("Invalid object class id");
        }

        return $objectClass;
    }
}