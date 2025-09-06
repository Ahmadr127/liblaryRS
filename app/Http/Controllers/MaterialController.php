<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        // Validasi rentang tanggal
        if ($request->filled('date_from') && $request->filled('date_to')) {
            if ($request->date_from > $request->date_to) {
                return redirect()->back()->withErrors([
                    'date_range' => 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.'
                ]);
            }
        }

        $perPage = $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? (int)$perPage : 10;
        
        $materials = Material::with(['uploader', 'files', 'category'])
            ->search($request->search)
            ->byCategory($request->category_id)
            ->dateRange($request->date_from, $request->date_to)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
        
        $categories = \App\Models\Category::orderBy('display_name')->get();
        return view('materials.index', compact('materials', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::orderBy('display_name')->get();
        return view('materials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'context' => 'nullable|string',
            'activity_date' => 'nullable|date',
            'activity_date_start' => 'nullable|date',
            'activity_date_end' => 'nullable|date|after_or_equal:activity_date_start',
            'file' => 'required|array|min:1',
            'file.*' => 'required|file|mimes:pdf|max:10240', // Max 10MB per file
        ]);

        // Validasi: minimal harus ada activity_date atau activity_date_start
        if (!$request->activity_date && !$request->activity_date_start) {
            return redirect()->back()->withErrors([
                'activity_date' => 'Tanggal kegiatan harus diisi (tanggal tunggal atau rentang tanggal).'
            ])->withInput();
        }

        // Jika menggunakan rentang tanggal, set activity_date_start sebagai activity_date untuk kompatibilitas
        if ($request->activity_date_start && !$request->activity_date) {
            $request->merge(['activity_date' => $request->activity_date_start]);
        }

        // Create the material first
        $material = Material::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'organizer' => $request->organizer,
            'source' => $request->source,
            'context' => $request->context,
            'activity_date' => $request->activity_date,
            'activity_date_start' => $request->activity_date_start,
            'activity_date_end' => $request->activity_date_end,
            'uploaded_by' => Auth::id(),
        ]);

        // Handle multiple files
        $files = $request->file('file');
        $uploadedFiles = [];

        foreach ($files as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');

            // Auto-copy untuk InfinityFree (jika symbolic link tidak berfungsi)
            $this->copyToPublicStorage($filePath);

            $materialFile = MaterialFile::create([
                'material_id' => $material->id,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
            ]);

            $uploadedFiles[] = $materialFile;
        }

        $message = count($uploadedFiles) > 1 
            ? 'Materi berhasil ditambahkan dengan ' . count($uploadedFiles) . ' file!' 
            : 'Materi berhasil ditambahkan dengan 1 file!';

        return redirect()->route('materials.index')->with('success', $message);
    }

    public function show(Material $material)
    {
        $material->load(['uploader', 'files', 'category']);
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $material->load(['files', 'category']);
        $categories = \App\Models\Category::orderBy('display_name')->get();
        return view('materials.edit', compact('material', 'categories'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'context' => 'nullable|string',
            'activity_date' => 'nullable|date',
            'activity_date_start' => 'nullable|date',
            'activity_date_end' => 'nullable|date|after_or_equal:activity_date_start',
            'file' => 'nullable|array',
            'file.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Validasi: minimal harus ada activity_date atau activity_date_start
        if (!$request->activity_date && !$request->activity_date_start) {
            return redirect()->back()->withErrors([
                'activity_date' => 'Tanggal kegiatan harus diisi (tanggal tunggal atau rentang tanggal).'
            ])->withInput();
        }

        // Jika menggunakan rentang tanggal, set activity_date_start sebagai activity_date untuk kompatibilitas
        if ($request->activity_date_start && !$request->activity_date) {
            $request->merge(['activity_date' => $request->activity_date_start]);
        }

        // Update material data
        $material->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'organizer' => $request->organizer,
            'source' => $request->source,
            'context' => $request->context,
            'activity_date' => $request->activity_date,
            'activity_date_start' => $request->activity_date_start,
            'activity_date_end' => $request->activity_date_end,
        ]);

        // Handle new file uploads
        if ($request->hasFile('file') && !empty($request->file('file')[0])) {
            $files = $request->file('file');
            
            foreach ($files as $file) {
                if ($file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('materials', $fileName, 'public');

                    // Auto-copy untuk InfinityFree (jika symbolic link tidak berfungsi)
                    $this->copyToPublicStorage($filePath);

                    MaterialFile::create([
                        'material_id' => $material->id,
                        'file_path' => $filePath,
                        'file_name' => $fileName,
                        'original_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
        }

        return redirect()->route('materials.index')->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroy(Material $material)
    {
        // Delete all associated files
        foreach ($material->files as $file) {
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
        }

        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Materi berhasil dihapus!');
    }

    public function downloadPublic(MaterialFile $materialFile)
    {
        $filePath = storage_path('app/public/' . $materialFile->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        // Increment download count (optional)
        // $materialFile->increment('downloads');

        return response()->download($filePath, $materialFile->original_name);
    }

    public function download(MaterialFile $materialFile)
    {
        if (!Storage::disk('public')->exists($materialFile->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($materialFile->file_path, $materialFile->original_name);
    }

    public function preview(MaterialFile $materialFile)
    {
        if (!Storage::disk('public')->exists($materialFile->file_path)) {
            abort(404);
        }

        // Get file content
        $fileContent = Storage::disk('public')->get($materialFile->file_path);
        
        // Get file mime type
        $mimeType = Storage::disk('public')->mimeType($materialFile->file_path);
        
        // Return file with appropriate headers for preview
        return response($fileContent)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $materialFile->original_name . '"');
    }

    public function previewPublic(MaterialFile $materialFile)
    {
        if (!Storage::disk('public')->exists($materialFile->file_path)) {
            abort(404);
        }

        // Get file content
        $fileContent = Storage::disk('public')->get($materialFile->file_path);
        
        // Get file mime type
        $mimeType = Storage::disk('public')->mimeType($materialFile->file_path);
        
        // Return file with appropriate headers for preview
        return response($fileContent)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $materialFile->original_name . '"');
    }

    public function deleteFile(MaterialFile $materialFile)
    {
        // Check if user has permission to delete this file
        if (Auth::id() !== $materialFile->material->uploaded_by && !Auth::user()->hasPermission('manage_materials')) {
            abort(403);
        }

        // Delete file from storage
        if (Storage::disk('public')->exists($materialFile->file_path)) {
            Storage::disk('public')->delete($materialFile->file_path);
        }

        // Delete file record
        $materialFile->delete();

        return back()->with('success', 'File berhasil dihapus!');
    }

    public function modal(Material $material)
    {
        $material->load(['uploader', 'files']);
        
        return response()->json([
            'id' => $material->id,
            'title' => $material->title,
            'category' => $material->category,
            'category_label' => $material->category_label,
            'organizer' => $material->organizer,
            'source' => $material->source,
            'context' => $material->context,
            'activity_date' => $material->activity_date ? $material->activity_date->format('Y-m-d') : null,
            'activity_date_formatted' => $material->activity_date ? $material->activity_date->format('d F Y') : null,
            'activity_date_range' => $material->activity_date_range,
            'uploader' => [
                'name' => $material->uploader->name,
            ],
            'files' => $material->files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'original_name' => $file->original_name,
                    'formatted_size' => $file->formatted_size,
                ];
            }),
            'created_at' => $material->created_at->format('Y-m-d H:i:s'),
            'created_at_formatted' => $material->created_at->format('d F Y H:i'),
            'updated_at' => $material->updated_at->format('Y-m-d H:i:s'),
            'updated_at_formatted' => $material->updated_at->format('d F Y H:i'),
        ]);
    }

    public function materialsForUser(Request $request)
    {
        // Validasi rentang tanggal
        if ($request->filled('date_from') && $request->filled('date_to')) {
            if ($request->date_from > $request->date_to) {
                return redirect()->back()->withErrors([
                    'date_range' => 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.'
                ]);
            }
        }

        $perPage = $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? (int)$perPage : 10;
        
        $materials = Material::with(['uploader', 'files', 'category'])
            ->search($request->search)
            ->byCategory($request->category_id)
            ->dateRange($request->date_from, $request->date_to)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
        
        $categories = \App\Models\Category::orderBy('display_name')->get();
        return view('materials.materialsforuser', compact('materials', 'categories'));
    }

    /**
     * Copy file dari storage/app/public ke public/storage untuk InfinityFree
     */
    private function copyToPublicStorage($filePath)
    {
        $sourcePath = storage_path('app/public/' . $filePath);
        $targetPath = public_path('storage/' . $filePath);
        
        // Buat direktori target jika belum ada
        $targetDir = dirname($targetPath);
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        // Copy file jika source ada dan target belum ada
        if (file_exists($sourcePath) && !file_exists($targetPath)) {
            copy($sourcePath, $targetPath);
        }
    }
}
