<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Action;
use App\Repository\ActionRepository;

class ActionManager
{
    /**
     * @var ActionRepository
     */
    private ActionRepository $actionRepository;

    /**
     * @param ActionRepository $actionRepository
     */
    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    /**
     * @return array
     */
    public function getAllActions(): array
    {
        return $this->actionRepository->findAll();
    }
}