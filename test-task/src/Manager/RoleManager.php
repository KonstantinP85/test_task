<?php

declare(strict_types=1);

namespace App\Manager;

use App\Repository\RoleRepository;

class RoleManager
{
    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return array
     */
    public function getAllRoles(): array
    {
        return $this->roleRepository->findAll();
    }
}