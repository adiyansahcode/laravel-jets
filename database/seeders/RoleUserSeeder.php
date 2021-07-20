<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    public function run()
    {
        // run seeder without event
        User::withoutEvents(function () {
            $adminRole = Role::find(1);
            $admin = User::find(1);
            $admin->role()->associate($adminRole);
            $admin->save();

            $userRole = Role::find(2);
            $user = User::where('id', '!=', 1)->get();
            foreach($user as $user) {
                $user->role()->associate($userRole);
                $user->save();
            }
        });
    }
}
