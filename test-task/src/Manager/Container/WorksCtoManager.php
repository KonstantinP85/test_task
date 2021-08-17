<?php

namespace App\Manager\Container;

use App\Entity\Container\WorksCto;
use App\Repository\Container\WorksCtoRepository;

class WorksCtoManager
{
    /**
     * @var WorksCtoRepository
     */
    private WorksCtoRepository $worksCtoRepository;

    /**
     * @param WorksCtoRepository $worksCtoRepository
     */
    public function __construct(WorksCtoRepository $worksCtoRepository)
    {
        $this->worksCtoRepository = $worksCtoRepository;
    }

    /**
     * @return array|WorksCto
     */
    public function getAll(): array
    {
        return $this->worksCtoRepository->findAll();
    }

    /**
     * @param string $id
     * @return WorksCto
     */
    public function get(string $id): WorksCto
    {
        return $this->worksCtoRepository->find($id);
    }
}