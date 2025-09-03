<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with(['uploader', 'files'])->latest()->paginate(10);
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:medis,keperawatan,umum',
            'title' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'file' => 'required|array|min:1',
            'file.*' => 'required|file|mimes:pdf|max:10240', // Max 10MB per file
        ]);

        // Create the material first
        $material = Material::create([
            'category' => $request->category,
            'title' => $request->title,
            'organizer' => $request->organizer,
            'source' => $request->source,
            'activity_date' => $request->activity_date,
            'uploaded_by' => Auth::id(),
        ]);

        // Handle multiple files
        $files = $request->file('file');
        $uploadedFiles = [];

        foreach ($files as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');

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
        $material->load(['uploader', 'files']);
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $material->load(['files']);
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'category' => 'required|in:medis,keperawatan,umum',
            'title' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'file' => 'nullable|array',
            'file.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Update material data
        $material->update([
            'category' => $request->category,
            'title' => $request->title,
            'organizer' => $request->organizer,
            'source' => $request->source,
            'activity_date' => $request->activity_date,
        ]);

        // Handle new file uploads
        if ($request->hasFile('file') && !empty($request->file('file')[0])) {
            $files = $request->file('file');
            
            foreach ($files as $file) {
                if ($file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('materials', $fileName, 'public');

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

    public function download(MaterialFile $materialFile)
    {
        if (!Storage::disk('public')->exists($materialFile->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($materialFile->file_path, $materialFile->original_name);
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
}
