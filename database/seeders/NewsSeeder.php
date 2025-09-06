<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Category;
use App\Models\User;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first admin user as author
        $admin = User::whereHas('role', function($query) {
            $query->where('name', 'admin');
        })->first();

        if (!$admin) {
            $this->command->warn('Admin user not found. Please run RolePermissionSeeder first.');
            return;
        }

        // Get categories
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        $newsData = [
            [
                'title' => 'Pembukaan Perpustakaan Digital RS Modern',
                'content' => '<p>Kami dengan bangga mengumumkan pembukaan perpustakaan digital RS Modern yang akan memberikan akses mudah terhadap berbagai materi pembelajaran dan referensi medis untuk seluruh staf rumah sakit.</p><p>Perpustakaan digital ini dilengkapi dengan berbagai fitur canggih seperti pencarian materi, kategorisasi yang terorganisir, dan akses 24/7 dari mana saja.</p><p>Dengan adanya perpustakaan digital ini, diharapkan dapat meningkatkan kualitas pelayanan kesehatan melalui peningkatan pengetahuan dan keterampilan staf medis.</p>',
                'excerpt' => 'Perpustakaan digital RS Modern resmi dibuka dengan berbagai fitur canggih untuk mendukung pembelajaran staf medis.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Pelatihan Penggunaan Sistem Perpustakaan Digital',
                'content' => '<p>Dalam rangka memaksimalkan penggunaan perpustakaan digital, RS Modern akan mengadakan pelatihan intensif untuk seluruh staf.</p><p>Pelatihan akan mencakup:</p><ul><li>Cara mengakses dan menggunakan sistem</li><li>Teknik pencarian materi yang efektif</li><li>Manajemen akun pengguna</li><li>Fitur-fitur advanced yang tersedia</li></ul><p>Pelatihan akan dilaksanakan secara bertahap sesuai dengan jadwal masing-masing departemen.</p>',
                'excerpt' => 'RS Modern mengadakan pelatihan intensif untuk memaksimalkan penggunaan perpustakaan digital bagi seluruh staf.',
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Penambahan Koleksi Materi Terbaru',
                'content' => '<p>Perpustakaan digital RS Modern telah menambahkan koleksi materi terbaru yang mencakup berbagai bidang medis dan keperawatan.</p><p>Materi baru yang ditambahkan meliputi:</p><ul><li>Panduan terbaru untuk penanganan COVID-19</li><li>Protokol keperawatan modern</li><li>Teknologi medis terkini</li><li>Best practices dalam pelayanan kesehatan</li></ul><p>Semua materi telah melalui proses review dan validasi oleh tim medis berpengalaman.</p>',
                'excerpt' => 'Perpustakaan digital menambahkan koleksi materi terbaru yang mencakup berbagai bidang medis dan keperawatan.',
                'status' => 'published',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Update Sistem Keamanan Perpustakaan Digital',
                'content' => '<p>Dalam upaya menjaga keamanan data dan privasi pengguna, sistem perpustakaan digital telah diupdate dengan fitur keamanan terbaru.</p><p>Fitur keamanan baru meliputi:</p><ul><li>Enkripsi data yang lebih kuat</li><li>Two-factor authentication</li><li>Audit trail yang lebih detail</li><li>Backup otomatis harian</li></ul><p>Update ini akan meningkatkan kepercayaan pengguna terhadap sistem dan memastikan data tetap aman.</p>',
                'excerpt' => 'Sistem perpustakaan digital diupdate dengan fitur keamanan terbaru untuk menjaga privasi dan keamanan data.',
                'status' => 'draft',
                'published_at' => null,
            ],
            [
                'title' => 'Feedback dan Saran Pengguna Perpustakaan Digital',
                'content' => '<p>Kami mengundang seluruh pengguna perpustakaan digital untuk memberikan feedback dan saran guna pengembangan sistem yang lebih baik.</p><p>Feedback yang kami harapkan meliputi:</p><ul><li>Kemudahan penggunaan interface</li><li>Kelengkapan materi yang tersedia</li><li>Kecepatan akses sistem</li><li>Saran fitur tambahan</li></ul><p>Feedback dapat disampaikan melalui email atau formulir yang tersedia di sistem.</p>',
                'excerpt' => 'Kami mengundang pengguna untuk memberikan feedback dan saran guna pengembangan sistem perpustakaan digital.',
                'status' => 'published',
                'published_at' => now()->subHours(6),
            ]
        ];

        foreach ($newsData as $index => $data) {
            $category = $categories->random();
            
            News::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'excerpt' => $data['excerpt'],
                'category_id' => $category->id,
                'author_id' => $admin->id,
                'status' => $data['status'],
                'published_at' => $data['published_at'],
                'views' => rand(10, 500),
            ]);
        }

        $this->command->info('News seeder completed successfully!');
    }
}
