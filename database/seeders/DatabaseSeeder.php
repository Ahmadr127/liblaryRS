<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed base data
        $this->call([
            RolePermissionSeeder::class,
            NewsPermissionSeeder::class,
            CategorySeeder::class,
        ]);

        // Ensure admin user exists before dependent seeders
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'role_id' => optional($adminRole)->id,
                'password' => Hash::make('password'),
            ]
        );

        // Seed content that may depend on admin/categories
        $this->call([
            NewsSeeder::class,
        ]);
    }
}
