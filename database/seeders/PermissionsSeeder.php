<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // run seeder without event
        Permission::withoutEvents(function () {
            // php faker
            $faker = \Faker\Factory::create();

            // truncate db
            Permission::truncate();

            $permissions = [
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'user access',
                    'param' => 'userAccess',
                    'detail' => 'permissions for access user page',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'user detail',
                    'param' => 'userDetail',
                    'detail' => 'permissions for show user detail',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'user create',
                    'param' => 'userCreate',
                    'detail' => 'permissions for create new user',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'user update',
                    'param' => 'userUpdate',
                    'detail' => 'permissions for update user',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'user delete',
                    'param' => 'userDelete',
                    'detail' => 'permissions for delete user',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'user activate',
                    'param' => 'userActivate',
                    'detail' => 'permissions for activate user',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'user deactivate',
                    'param' => 'userDeactivate',
                    'detail' => 'permissions for deactivate user',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'role access',
                    'param' => 'roleAccess',
                    'detail' => 'permissions for access role page',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'role detail',
                    'param' => 'roleDetail',
                    'detail' => 'permissions for show role detail',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'role create',
                    'param' => 'roleCreate',
                    'detail' => 'permissions for create new role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'role update',
                    'param' => 'roleUpdate',
                    'detail' => 'permissions for update role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'role delete',
                    'param' => 'roleDelete',
                    'detail' => 'permissions for delete role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'role activate',
                    'param' => 'roleActivate',
                    'detail' => 'permissions for activate role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'role deactivate',
                    'param' => 'roleDeactivate',
                    'detail' => 'permissions for deactivate role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
            ];

            Permission::insert($permissions);
        });
    }
}
