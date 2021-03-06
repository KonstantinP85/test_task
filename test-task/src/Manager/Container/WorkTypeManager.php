<?php

declare(strict_types=1);

namespace App\Manager\Container;

use App\Entity\Container\WorkType;
use App\Repository\Container\WorkTypeRepository;

class WorkTypeManager
{
    /**
     * @var WorkTypeRepository
     */
    private WorkTypeRepository $workTypeRepository;

    /**
     * @param WorkTypeRepository $workTypeRepository
     */
    public function __construct(WorkTypeRepository $workTypeRepository)
    {
        $this->workTypeRepository = $workTypeRepository;
    }

    /**
     * @return array|WorkType
     */
    public function getAll(): array
    {
        return $this->workTypeRepository->findAll();
    }

    /**
     * @param string $id
     * @return WorkType
     */
    public function get(string $id): WorkType
    {
        return $this->workTypeRepository->find($id);
    }
}