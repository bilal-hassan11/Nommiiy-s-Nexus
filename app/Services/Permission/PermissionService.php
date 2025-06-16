<?php

namespace App\Services\Permission;

use App\Services\BaseService;
use App\Repositories\Permission\PermissionRepository;

class PermissionService extends BaseService
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        parent::__construct($permissionRepository);
        $this->permissionRepository = $permissionRepository;
    }

    public function getPermissions(string $modelName): array
    {
        return $this->permissionRepository->getPermissions($modelName);
    }
}
