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
        
        $medisCount = Material::where('category', 'medis')->count();
        $keperawatanCount = Material::where('category', 'keperawatan')->count();
        $umumCount = Material::where('category', 'umum')->count();
        
        // Get recent materials with file count
        $recentMaterials = Material::with(['uploader', 'files'])
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
