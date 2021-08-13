<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\WorkType;
use App\Repository\WorkTypeRepository;

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
     * @return array
     */
    public function getAllWorkType(): array
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