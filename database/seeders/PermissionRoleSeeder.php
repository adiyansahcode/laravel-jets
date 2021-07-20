<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
        $adminPermissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($adminPermissions->pluck('id'));
    }
}
