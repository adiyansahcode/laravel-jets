<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // run seeder without event
        Role::withoutEvents(function () {
            // php faker
            $faker = \Faker\Factory::create();

            $roles = [
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'Admin',
                    'detail' => 'admin role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'title' => 'User',
                    'detail' => 'user role',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                ],
            ];

            Role::insert($roles);
        });
    }
}
