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
                    'title' => 'userAccess',
                    'detail' => 'permissions for access user page',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'userDetail',
                    'detail' => 'permissions for show user detail',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'userCreate',
                    'detail' => 'permissions for create new user',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'userUpdate',
                    'detail' => 'permissions for update user',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'userDelete',
                    'detail' => 'permissions for delete user',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'roleAccess',
                    'detail' => 'permissions for access role page',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'roleDetail',
                    'detail' => 'permissions for show role detail',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'roleCreate',
                    'detail' => 'permissions for create new role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'roleUpdate',
                    'detail' => 'permissions for update role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'roleDelete',
                    'detail' => 'permissions for delete role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
            ];

            Permission::insert($permissions);
        });
    }
}
