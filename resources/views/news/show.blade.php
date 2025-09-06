@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')
<div class="w-full mx-auto max-w-4xl">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Detail Berita</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('news.edit', $news) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('news.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- News Header -->
            <div class="border-b pb-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $news->title }}</h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <i class="fas fa-user mr-1"></i>
                                {{ $news->author->name }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $news->created_at->format('d M Y H:i') }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-eye mr-1"></i>
                                {{ number_format($news->views) }} views
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end space-y-2">
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-100 text-gray-800',
                                'published' => 'bg-green-100 text-green-800',
                                'archived' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$news->status] }}">
                            {{ $news->status_label }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $news->category->display_name }}
                        </span>
                    </div>
                </div>

                @if($news->published_at)
                <div class="text-sm text-gray-600">
                    <i class="fas fa-clock mr-1"></i>
                    Dipublikasi pada: {{ $news->published_at->format('d F Y H:i') }}
                </div>
                @endif
            </div>

            <!-- Featured Image -->
            @if($news->image)
            <div class="border-b pb-6">
                <img src="{{ $news->image_url }}" alt="{{ $news->title }}" 
                     class="w-full h-64 object-cover rounded-lg shadow-lg">
            </div>
            @endif


            <!-- Content -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Konten</h3>
                <div class="prose max-w-none">
                    {!! $news->content !!}
                </div>
            </div>

            <!-- Meta Information -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Detail</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Informasi Dasar</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">ID Berita:</dt>
                                <dd class="text-sm text-gray-900">#{{ $news->id }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Slug:</dt>
                                <dd class="text-sm text-gray-900 font-mono">{{ $news->slug }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Status:</dt>
                                <dd class="text-sm">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$news->status] }}">
                                        {{ $news->status_label }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Kategori:</dt>
                                <dd class="text-sm text-gray-900">{{ $news->category->display_name }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Statistik</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Total Views:</dt>
                                <dd class="text-sm text-gray-900">{{ number_format($news->views) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Dibuat:</dt>
                                <dd class="text-sm text-gray-900">{{ $news->created_at->format('d M Y H:i') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Terakhir Diupdate:</dt>
                                <dd class="text-sm text-gray-900">{{ $news->updated_at->format('d M Y H:i') }}</dd>
                            </div>
                            @if($news->published_at)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Dipublikasi:</dt>
                                <dd class="text-sm text-gray-900">{{ $news->published_at->format('d M Y H:i') }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($news->meta_data && (isset($news->meta_data['meta_title']) || isset($news->meta_data['meta_description'])))
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO & Meta Data</h3>
                <div class="space-y-4">
                    @if(isset($news->meta_data['meta_title']))
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Meta Title</h4>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $news->meta_data['meta_title'] }}</p>
                    </div>
                    @endif
                    
                    @if(isset($news->meta_data['meta_description']))
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Meta Description</h4>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $news->meta_data['meta_description'] }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6">
                <div class="flex space-x-2">
                    <form action="{{ route('news.toggle-status', $news) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-{{ $news->status === 'published' ? 'orange' : 'green' }}-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-{{ $news->status === 'published' ? 'orange' : 'green' }}-700 focus:bg-{{ $news->status === 'published' ? 'orange' : 'green' }}-700 active:bg-{{ $news->status === 'published' ? 'orange' : 'green' }}-800 focus:outline-none focus:ring-2 focus:ring-{{ $news->status === 'published' ? 'orange' : 'green' }}-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-{{ $news->status === 'published' ? 'eye-slash' : 'eye' }} mr-2"></i>
                            {{ $news->status === 'published' ? 'Set Draft' : 'Publish' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('public.news.show', $news) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Lihat Publik
                    </a>
                </div>
                
                <form action="{{ route('news.destroy', $news) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.prose {
    color: #374151;
    line-height: 1.75;
}

.prose p {
    margin-bottom: 1rem;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #111827;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose ul, .prose ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose blockquote {
    border-left: 4px solid #e5e7eb;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
}

.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1rem 0;
}
</style>

@endsection
