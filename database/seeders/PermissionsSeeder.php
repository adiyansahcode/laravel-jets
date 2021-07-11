<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'title' => 'user_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
