<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Competition;
use App\Models\Round;
use App\Models\Competitor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'Admin',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
            'is_admin' => true,
        ]);

        User::factory()
            ->count(50)
            ->create();

        Competition::factory()
            ->count(5)
            ->create();

        for($i = 0; $i < 25; $i++){
            Round::factory()->create();
        }

        for($i = 0; $i < 200; $i++){
            Competitor::factory()->create();
        }

    }
}
