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
    protected $signature = 'storage:sync';

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
        $sourceDir = storage_path('app/public');
        $targetDir = public_path('storage');

        $this->info('Memulai sync storage files...');

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
}
