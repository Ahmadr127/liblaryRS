<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class NewsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create News Permissions
        $newsPermissions = [
            ['name' => 'manage_news', 'display_name' => 'Kelola Berita', 'description' => 'Mengelola berita dan artikel'],
            ['name' => 'view_news', 'display_name' => 'Lihat Berita', 'description' => 'Melihat daftar berita dan artikel'],
        ];

        foreach ($newsPermissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Assign permissions to roles
        $adminRole = Role::where('name', 'admin')->first();
        $librarianRole = Role::where('name', 'librarian')->first();
        $userRole = Role::where('name', 'user')->first();

        if ($adminRole) {
            // Admin gets all permissions
            $adminRole->permissions()->syncWithoutDetaching(
                Permission::whereIn('name', ['manage_news', 'view_news'])->get()
            );
        }

        if ($librarianRole) {
            // Librarian gets manage_news and view_news
            $librarianRole->permissions()->syncWithoutDetaching(
                Permission::whereIn('name', ['manage_news', 'view_news'])->get()
            );
        }

        if ($userRole) {
            // User gets only view_news
            $userRole->permissions()->syncWithoutDetaching(
                Permission::where('name', 'view_news')->get()
            );
        }

        $this->command->info('News permissions added successfully!');
    }
}