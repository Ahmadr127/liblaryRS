<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Console\Commands\SyncStorage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::with(['category', 'author']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $news = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('display_name')->get();

        return view('news.index', compact('news', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('display_name')->get();
        return view('news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {

        $data = $request->only([
            'title', 'content', 'category_id', 
            'status', 'published_at'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('news', $imageName, 'public');
            $data['image'] = $imagePath;

            // Auto-copy untuk InfinityFree
            $this->copyToPublicStorage($imagePath);
        }

        // Set author
        $data['author_id'] = Auth::id();

        // Set published_at jika status published
        if ($request->status === 'published' && !$request->published_at) {
            $data['published_at'] = now();
        }


        News::create($data);

        return redirect()->route('news.index')->with('success', 'Berita berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $news->load(['category', 'author']);
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $categories = Category::orderBy('display_name')->get();
        return view('news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {

        $data = $request->only([
            'title', 'content', 'category_id', 
            'status', 'published_at'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('news', $imageName, 'public');
            $data['image'] = $imagePath;

            // Auto-copy untuk InfinityFree
            $this->copyToPublicStorage($imagePath);
        }

        // Set published_at jika status published dan belum ada
        if ($request->status === 'published' && !$request->published_at && !$news->published_at) {
            $data['published_at'] = now();
        }


        $news->update($data);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Delete image if exists
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Toggle status berita
     */
    public function toggleStatus(News $news)
    {
        $newStatus = $news->status === 'published' ? 'draft' : 'published';
        
        $data = ['status' => $newStatus];
        
        if ($newStatus === 'published' && !$news->published_at) {
            $data['published_at'] = now();
        }

        $news->update($data);

        $statusLabel = $newStatus === 'published' ? 'dipublikasi' : 'disimpan sebagai draft';
        
        return back()->with('success', "Berita berhasil {$statusLabel}!");
    }

    /**
     * Public view untuk berita
     */
    public function publicShow(News $news)
    {
        if (!$news->isPublished()) {
            abort(404);
        }

        $news->incrementViews();
        $news->load(['category', 'author']);

        // Get related news
        $relatedNews = News::published()
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->limit(4)
            ->get();

        return view('news.public.show', compact('news', 'relatedNews'));
    }

    /**
     * Public listing untuk berita
     */
    public function publicIndex(Request $request)
    {
        $query = News::published()->with(['category', 'author']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $news = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = Category::orderBy('display_name')->get();

        return view('news.public.index', compact('news', 'categories'));
    }

    /**
     * Copy file dari storage/app/public ke public/storage untuk InfinityFree
     */
    private function copyToPublicStorage($filePath)
    {
        // Delegasikan ke helper command agar satu sumber kebenaran
        SyncStorage::copySinglePublicFileToPublicStorage($filePath);
    }
}
