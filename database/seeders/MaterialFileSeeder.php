<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\MaterialFile;
use Illuminate\Support\Facades\Storage;

class MaterialFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all materials
        $materials = Material::all();
        
        if ($materials->isEmpty()) {
            $this->command->info('No materials found. Please create materials first.');
            return;
        }

        // Get files from storage
        $storagePath = storage_path('app/public/materials');
        if (!is_dir($storagePath)) {
            $this->command->info('Materials storage directory not found.');
            return;
        }

        $files = scandir($storagePath);
        $pdfFiles = array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
        });

        if (empty($pdfFiles)) {
            $this->command->info('No PDF files found in storage.');
            return;
        }

        $this->command->info('Found ' . count($pdfFiles) . ' PDF files in storage.');

        // Assign files to materials
        foreach ($materials as $index => $material) {
            if (isset($pdfFiles[$index])) {
                $fileName = $pdfFiles[$index];
                $filePath = 'materials/' . $fileName;
                $fullPath = $storagePath . '/' . $fileName;
                
                if (file_exists($fullPath)) {
                    $fileSize = filesize($fullPath);
                    $originalName = pathinfo($fileName, PATHINFO_FILENAME);
                    
                    // Create material file record
                    MaterialFile::create([
                        'material_id' => $material->id,
                        'file_path' => $filePath,
                        'file_name' => $fileName,
                        'original_name' => $originalName . '.pdf',
                        'file_size' => $fileSize,
                    ]);
                    
                    $this->command->info("Assigned file '{$fileName}' to material '{$material->title}'");
                }
            }
        }

        $this->command->info('Material files seeding completed!');
    }
}
