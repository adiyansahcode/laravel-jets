<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // run seeder without event
        User::withoutEvents(function () {
            // php faker
            $faker = \Faker\Factory::create();

            // Create user manual with DB Facades
            DB::table('users')->insert([
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'uuid' => $faker->uuid(),
                    'name' => 'admin',
                    'username' => 'admin',
                    'phone' => '01234567',
                    'email' => 'admin@email.com',
                    'email_verified_at' => now(),
                    'password' => app('hash')->make('admin'),
                ],
            ]);

            // Create user manual with model eloquent
            $user = new User();
            $user->uuid = $faker->uuid();
            $user->name = 'user';
            $user->username = 'user';
            $user->phone = '7890123';
            $user->email = 'user@email.com';
            $user->email_verified_at = now();
            $user->password = app('hash')->make('user');
            $user->save();

            // Create user random with factory
            User::factory(20)->create();

            $admin = User::find(1);
            $user = User::all();
            foreach($user as $user) {
                $user->createdBy()->associate($admin);
                $user->updatedBy()->associate($admin);
                $user->save();
            }
        });
    }
}
