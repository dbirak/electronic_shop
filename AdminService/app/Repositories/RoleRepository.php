<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository implements IRoleRepository
{
    public function getRoleById(int $roleId)
    {
        return Role::where('id', $roleId)->first();
    }
}
