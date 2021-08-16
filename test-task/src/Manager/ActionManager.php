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
     * @return array|Action[]
     */
    public function getAllActions(): array
    {
        return $this->actionRepository->findAll();
    }

    /**
     * @param $id
     * @return Action
     * @throws \Exception
     */
    public function get($id): Action
    {
        $action = $this->actionRepository->find($id);
        if (!$action instanceof Action) {
            throw new \Exception("Invalid action id");
        }

        return $action;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        $actions = $this->getAllActions();
        foreach ($actions as $action) {
            $result[] = [
                'id' => $action->getId(),
                'name' => $action->getName(),
                'signature' => $action->getSignature()
            ];
        }

        return $result;
    }
}