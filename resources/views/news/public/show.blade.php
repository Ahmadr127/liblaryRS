@extends('layouts.landing')

@section('title', $news->title . ' - Digital Library RS')

@section('content')
<div class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('landing') }}" class="hover:text-teal-600">Beranda</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('public.news.index') }}" class="hover:text-teal-600">Berita</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900 font-medium">{{ $news->title }}</span>
        </nav>
    </div>
    </div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                @if($news->image_url)
                <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-auto max-h-[560px] object-contain bg-gray-50">
                @else
                <img src="{{ asset('images/news.png') }}" alt="Gambar tidak tersedia" class="w-full h-auto max-h-[560px] object-contain bg-gray-50">
                @endif
                <div class="p-6">
                    <div class="text-sm text-gray-500 mb-1">
                        Dipublikasi {{ $news->published_at?->format('d M Y') }}
                        @if($news->category)
                        • {{ $news->category->display_name }}
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
                    <div class="prose max-w-none text-gray-800">
                        {!! $news->content !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-6">
            @if($relatedNews->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Berita Terkait</h2>
                <div class="space-y-3">
                    @foreach($relatedNews as $item)
                    <a href="{{ route('public.news.show', $item) }}" class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50">
                        @if($item->image_url)
                        <img src="{{ $item->image_url }}" class="w-16 h-16 object-cover rounded" alt="{{ $item->title }}">
                        @endif
                        <div>
                            <div class="text-xs text-gray-500">{{ $item->published_at?->format('d M Y') }}</div>
                            <div class="text-sm font-medium text-gray-900 line-clamp-2">{{ $item->title }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.prose { line-height: 1.7; }
.prose p { margin-bottom: 1rem; }
</style>
@endsection


