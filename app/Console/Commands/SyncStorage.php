<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:sync {path? : Relative path inside storage/app/public to sync (optional)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync storage files to public directory for InfinityFree hosting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $relativePath = trim((string)($this->argument('path') ?? ''), " \/");
        $sourceDir = $relativePath
            ? storage_path('app/public/' . $relativePath)
            : storage_path('app/public');
        $targetDir = public_path('storage');

        $this->info('Memulai sync storage files' . ($relativePath ? ' untuk path: ' . $relativePath : '') . '...');

        // Buat direktori target jika belum ada
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
            $this->info('Direktori target dibuat: ' . $targetDir);
        }

        // Copy semua file dan folder
        $this->copyDirectory($sourceDir, $targetDir);

        $this->info('Sync storage berhasil diselesaikan!');
    }

    /**
     * Copy directory recursively
     */
    private function copyDirectory($source, $destination)
    {
        if (!File::exists($source)) {
            $this->error('Source directory tidak ditemukan: ' . $source);
            return;
        }

        $files = File::allFiles($source);
        $directories = File::directories($source);

        // Copy files
        foreach ($files as $file) {
            $relativePath = str_replace($source . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $targetPath = $destination . DIRECTORY_SEPARATOR . $relativePath;
            $targetDir = dirname($targetPath);

            // Buat direktori target jika belum ada
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            // Copy file
            File::copy($file->getPathname(), $targetPath);
            $this->line('Copied: ' . $relativePath);
        }

        // Copy subdirectories
        foreach ($directories as $directory) {
            $relativePath = str_replace($source . DIRECTORY_SEPARATOR, '', $directory);
            $targetPath = $destination . DIRECTORY_SEPARATOR . $relativePath;
            
            if (!File::exists($targetPath)) {
                File::makeDirectory($targetPath, 0755, true);
            }
            
            $this->copyDirectory($directory, $targetPath);
        }
    }

    /**
     * Fallback helper (static) untuk menyalin satu file dari storage/app/public
     * ke public/storage saat symbolic link tidak berfungsi (mis. di InfinityFree).
     *
     * Gunakan nilai relative path terhadap disk 'public', contoh:
     *   news/abc.jpg atau materials/file.pdf
     */
    public static function copySinglePublicFileToPublicStorage(string $relativePath): bool
    {
        $relativePath = trim($relativePath, " \/");
        if ($relativePath === '') {
            return false;
        }

        $sourcePath = storage_path('app/public/' . $relativePath);
        $targetPath = public_path('storage/' . $relativePath);

        if (!File::exists($sourcePath)) {
            return false;
        }

        $targetDir = dirname($targetPath);
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        if (!File::exists($targetPath)) {
            return File::copy($sourcePath, $targetPath);
        }

        return true; // Sudah ada di target
    }
}
