<?php

namespace App\Repositories;

use App\Models\Role;

interface IRoleRepository
{
    public function getRoleById(int $roleId);
}
