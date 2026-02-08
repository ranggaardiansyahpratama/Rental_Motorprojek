<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin and sample users for the rental motor system
        $this->call([
            AdminUserSeeder::class,
            MotorSeeder::class,
        ]);
    }
}
