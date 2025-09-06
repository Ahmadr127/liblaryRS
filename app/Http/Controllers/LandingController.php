<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Base query with filters
        $baseQuery = Material::with(['uploader', 'files', 'category'])
            ->search($request->search)
            ->byCategory($request->category_id)
            ->dateRange($request->date_from, $request->date_to);

        // Get featured materials (latest 6)
        $featuredMaterials = (clone $baseQuery)->latest()->take(6)->get();
        
        // Get all materials for client-side pagination (no server-side pagination)
        $allMaterials = (clone $baseQuery)->latest()->get();
        
        // Format materials for the integrated materials section
        $formattedMaterials = $allMaterials->map(function ($material) {
            return [
                'id' => $material->id,
                'title' => $material->title,
                'source' => $material->source,
                'organizer' => $material->organizer,
                'context' => $material->context,
                'category_id' => $material->category_id,
                'category_label' => $material->category_label,
                'display_activity_date' => $material->display_activity_date,
                'activity_date' => $material->activity_date?->format('Y-m-d'),
                'activity_date_start' => $material->activity_date_start?->format('Y-m-d'),
                'activity_date_end' => $material->activity_date_end?->format('Y-m-d'),
                'created_at' => $material->created_at->toISOString(),
                'uploader' => $material->uploader ? [
                    'name' => $material->uploader->name
                ] : null,
                'files_count' => $material->files->count(),
                'bookmarked' => false
            ];
        });
        
        // Get categories for filter
        $categories = Category::orderBy('display_name')->get();
        
        // Get materials count by category for statistics
        $categoryStats = Category::withCount('materials')->get();
        
        // Get recent materials (last 30 days)
        $recentMaterials = Material::with(['category', 'files'])
            ->where('created_at', '>=', now()->subDays(30))
            ->latest()
            ->take(4)
            ->get();

        // Prepare flattened materials for calendar (respecting current filters)
        $calendarMaterials = (clone $baseQuery)->latest()->get()->map(function ($m) {
            return [
                'id' => $m->id,
                'title' => $m->title,
                'organizer' => $m->organizer,
                'category_label' => $m->category_label,
                'source' => $m->source,
                'context' => $m->context,
                'display_activity_date' => $m->display_activity_date,
                'activity_date_range' => $m->activity_date_range,
                'activity_date' => $m->activity_date?->format('Y-m-d'),
                'activity_date_start' => $m->activity_date_start?->format('Y-m-d'),
                'activity_date_end' => $m->activity_date_end?->format('Y-m-d'),
                'uploader' => $m->uploader ? [ 'name' => $m->uploader->name ] : null,
            ];
        });

        // Latest published news for landing section
        $latestNews = News::published()
            ->with(['category'])
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('landing', compact(
            'featuredMaterials', 
            'formattedMaterials',
            'categories', 
            'categoryStats', 
            'recentMaterials',
            'calendarMaterials',
            'latestNews'
        ));
    }

    public function materials(Request $request)
    {
        // Get all materials with relationships
        $materials = Material::with(['uploader', 'files', 'category'])
            ->search($request->search)
            ->byCategory($request->category_id)
            ->dateRange($request->date_from, $request->date_to)
            ->latest()
            ->get()
            ->map(function ($material) {
                return [
                    'id' => $material->id,
                    'title' => $material->title,
                    'source' => $material->source,
                    'organizer' => $material->organizer,
                    'context' => $material->context,
                    'category_id' => $material->category_id,
                    'category_label' => $material->category_label,
                    'display_activity_date' => $material->display_activity_date,
                    'activity_date' => $material->activity_date?->format('Y-m-d'),
                    'activity_date_start' => $material->activity_date_start?->format('Y-m-d'),
                    'activity_date_end' => $material->activity_date_end?->format('Y-m-d'),
                    'created_at' => $material->created_at->toISOString(),
                    'uploader' => $material->uploader ? [
                        'name' => $material->uploader->name
                    ] : null,
                    'files_count' => $material->files->count(),
                    'bookmarked' => false // You can implement bookmark logic here
                ];
            });

        // Get categories for filter
        $categories = Category::orderBy('display_name')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'display_name' => $category->display_name
            ];
        });

        return view('public.materials', compact('materials', 'categories'));
    }

    public function materialDetail(Material $material)
    {
        // Load relationships
        $material->load(['uploader', 'files', 'category']);

        // Get related materials from same category
        $relatedMaterials = Material::with(['category', 'files'])
            ->where('category_id', $material->category_id)
            ->where('id', '!=', $material->id)
            ->latest()
            ->take(4)
            ->get();

        // Determine status
        $today = now()->format('Y-m-d');
        $start = $material->activity_date_start?->format('Y-m-d') ?? $material->activity_date?->format('Y-m-d');
        $end = $material->activity_date_end?->format('Y-m-d') ?? $material->activity_date?->format('Y-m-d');

        if (!$start) {
            $statusClass = 'bg-gray-100 text-gray-700';
            $statusLabel = 'Tidak terjadwal';
        } elseif ($today < $start) {
            $statusClass = 'bg-blue-100 text-blue-700';
            $statusLabel = 'Akan berlangsung';
        } elseif ($end && $today > $end) {
            $statusClass = 'bg-gray-100 text-gray-700';
            $statusLabel = 'Sudah berlangsung';
        } else {
            $statusClass = 'bg-green-100 text-green-700';
            $statusLabel = 'Sedang berlangsung';
        }

        // Increment view count (optional)
        // $material->increment('views');

        return view('public.material-detail', compact(
            'material', 
            'relatedMaterials', 
            'statusClass', 
            'statusLabel'
        ));
    }

    public function about()
    {
        return view('public.about');
    }
}