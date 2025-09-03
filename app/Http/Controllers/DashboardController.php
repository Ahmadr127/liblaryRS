<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get material statistics
        $totalMaterials = Material::count();
        $totalFiles = MaterialFile::count();
        
        // Hitung berdasarkan relasi kategori (name: medis/keperawatan/umum)
        $medisCount = Material::whereHas('category', function($q){
            $q->where('name', 'medis');
        })->count();
        $keperawatanCount = Material::whereHas('category', function($q){
            $q->where('name', 'keperawatan');
        })->count();
        $umumCount = Material::whereHas('category', function($q){
            $q->where('name', 'umum');
        })->count();
        
        // Get recent materials with file count
        $recentMaterials = Material::with(['uploader', 'files', 'category'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'user', 
            'totalMaterials', 
            'totalFiles',
            'medisCount', 
            'keperawatanCount', 
            'umumCount', 
            'recentMaterials'
        ));
    }
}
