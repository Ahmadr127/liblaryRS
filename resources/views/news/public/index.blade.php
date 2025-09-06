@extends('layouts.landing')

@section('title', 'Berita - Digital Library RS')

@section('content')
<div class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('landing') }}" class="hover:text-teal-600">Beranda</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900 font-medium">Berita</span>
        </nav>
    </div>
    </div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Filters -->
    <form method="GET" class="bg-white border border-gray-200 rounded-xl p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-5">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm">
            </div>
            <div class="md:col-span-4">
                <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->display_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3 flex gap-2">
                <button class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm">Terapkan</button>
                <a href="{{ route('public.news.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm">Reset</a>
            </div>
        </div>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
        <div class="lg:col-span-7 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($news as $item)
                <a href="{{ route('public.news.show', $item) }}" class="block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    @php $img = $item->image_url ?? asset('images/news.png'); @endphp
                    <div class="w-full h-28 bg-gray-50 flex items-center justify-center overflow-hidden">
                        <img src="{{ $img }}" alt="{{ $item->title }}" class="max-h-28 w-auto object-contain">
                    </div>
                    <div class="p-3">
                        <div class="text-[11px] text-gray-500 mb-1">
                            {{ $item->published_at?->format('d M Y') }}
                            @if($item->category)
                            • {{ $item->category->display_name }}
                            @endif
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-1">{{ $item->title }}</h3>
                        <p class="text-xs text-gray-600 line-clamp-3">{{ $item->excerpt }}</p>
                    </div>
                </a>
                @empty
                <div class="text-gray-600">Tidak ada berita ditemukan.</div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $news->links() }}
            </div>
        </div>

        <div class="lg:col-span-3 space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Kategori</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $category)
                    <a href="{{ request()->fullUrlWithQuery(['category_id' => $category->id]) }}" class="px-3 py-1.5 bg-gray-100 rounded-full text-xs text-gray-700 hover:bg-gray-200">{{ $category->display_name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endsection


