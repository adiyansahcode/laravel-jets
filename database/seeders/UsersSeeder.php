<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Team;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php faker
        $faker = \Faker\Factory::create();

        // truncate db
        DB::table('users')->truncate();
        DB::table('teams')->truncate();

        // Create user manual with DB Facades
        DB::table('users')->insert([
            [
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'admin',
                'email' => 'admin@email.com',
                'email_verified_at' => now(),
                'password' => app('hash')->make('admin'),
            ],
        ]);
        DB::table('teams')->insert([
            [
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => 1,
                'name' => 'admin' . '\'s Team',
                'personal_team' => true
            ],
        ]);

        // Create user manual with model eloquent
        $user = new User();
        $user->name = 'user';
        $user->email = 'user@email.com';
        $user->email_verified_at = now();
        $user->password = app('hash')->make('user');
        $user->save();

        $team = new Team();
        $team->user_id = $user->id;
        $team->name = $user->name . '\'s Team';
        $team->personal_team = true;
        $team->save();

        // Create user random
        User::factory(20)->withPersonalTeam()->create();
    }
}
