<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            ['name' => 'manage_roles', 'display_name' => 'Kelola Roles', 'description' => 'Mengelola roles dan permissions'],
            ['name' => 'manage_permissions', 'display_name' => 'Kelola Permissions', 'description' => 'Mengelola permissions'],
            ['name' => 'view_dashboard', 'display_name' => 'Lihat Dashboard', 'description' => 'Melihat halaman dashboard'],
            ['name' => 'manage_users', 'display_name' => 'Kelola Users', 'description' => 'Mengelola pengguna'],
            ['name' => 'manage_materials', 'display_name' => 'Kelola Materi', 'description' => 'Mengelola materi perpustakaan'],
            ['name' => 'view_materials', 'display_name' => 'Lihat Materi', 'description' => 'Melihat daftar materi perpustakaan'],
            ['name' => 'manage_categories', 'display_name' => 'Kelola Kategori', 'description' => 'Mengelola master kategori materi'],
            ['name' => 'view_categories', 'display_name' => 'Lihat Kategori', 'description' => 'Melihat master kategori materi'],
            ['name' => 'manage_news', 'display_name' => 'Kelola Berita', 'description' => 'Mengelola berita dan artikel'],
            ['name' => 'view_news', 'display_name' => 'Lihat Berita', 'description' => 'Melihat daftar berita dan artikel'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create Roles
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Role dengan akses penuh ke sistem'
        ]);

        $librarianRole = Role::create([
            'name' => 'librarian',
            'display_name' => 'Pustakawan',
            'description' => 'Role untuk mengelola perpustakaan'
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'Pengguna',
            'description' => 'Role untuk pengguna umum'
        ]);

        // Assign permissions to roles
        $adminRole->permissions()->attach(Permission::all()); // Admin gets all permissions
        
        $librarianRole->permissions()->attach(
            Permission::whereIn('name', [
                'view_dashboard',
                'manage_materials',
                'view_materials',
                'manage_categories',
                'view_categories',
                'manage_news',
                'view_news'
            ])->get()
        );
        
        $userRole->permissions()->attach(
            Permission::whereIn('name', [
                'view_dashboard',
                'view_materials',
                'view_categories',
                'view_news'
            ])->get()
        );
    }
}
