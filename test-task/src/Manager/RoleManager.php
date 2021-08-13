<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Role;
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

    /**
     * @param $id
     * @return Role
     * @throws \Exception
     */
    public function get($id): Role
    {
        $role = $this->roleRepository->find($id);
        if (!$role instanceof Role) {
            throw new \Exception("Invalid role id");
        }

        return $role;
    }
}