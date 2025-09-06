@extends('layouts.app')

@section('title', 'Daftar Berita')

@section('content')
<div class="w-full mx-auto" x-data="{
    isOpen: false,
    loading: false,
    news: null,
    ...tableFilter({
        search: '{{ request('search') }}',
        category_id: '{{ request('category_id') }}',
        status: '{{ request('status') }}'
    }),
    
    async openModal(newsId) {
        this.isOpen = true;
        this.loading = true;
        this.news = null;
        
        try {
            const response = await fetch(`/news/${newsId}`);
            if (response.ok) {
                this.news = await response.json();
            } else {
                console.error('Failed to load news details:', response.status, response.statusText);
            }
        } catch (error) {
            console.error('Error loading news details:', error);
        } finally {
            this.loading = false;
        }
    },
    
    closeModal() {
        this.isOpen = false;
        this.news = null;
    }
}">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Berita</h2>
                <a href="{{ route('news.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Berita
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Terjadi kesalahan
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Filter Section -->
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <form method="GET" action="{{ route('news.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Cari judul atau konten..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                    </select>
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search mr-1"></i>Filter
                    </button>
                    <a href="{{ route('news.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        <i class="fas fa-times mr-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Publikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($news as $item)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-start space-x-3">
                                @if($item->image)
                                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" 
                                         class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 line-clamp-2">{{ $item->title }}</div>
                                    <div class="text-sm text-gray-500 mt-1 line-clamp-2">{{ Str::limit(strip_tags($item->content), 100) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                bg-blue-100 text-blue-800">
                                {{ $item->category->display_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    'published' => 'bg-green-100 text-green-800',
                                    'archived' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$item->status] }}">
                                {{ $item->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $item->author->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($item->published_at)
                                {{ $item->published_at->format('d M Y H:i') }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-eye text-gray-400 mr-1"></i>
                                {{ number_format($item->views) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button @click="openModal({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('news.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('news.toggle-status', $item) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-{{ $item->status === 'published' ? 'orange' : 'green' }}-600 hover:text-{{ $item->status === 'published' ? 'orange' : 'green' }}-900" 
                                            title="{{ $item->status === 'published' ? 'Set Draft' : 'Publish' }}">
                                        <i class="fas fa-{{ $item->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('news.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada berita yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($news->hasPages())
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $news->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Component -->
    <div x-show="isOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900" id="modal-title">Detail Berita</h3>
                        <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div x-show="loading" class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i>
                        <p class="mt-2 text-gray-500">Memuat data...</p>
                    </div>
                    
                    <div x-show="!loading && news" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul</label>
                                <p class="mt-1 text-sm text-gray-900" x-text="news?.title"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <p class="mt-1 text-sm text-gray-900" x-text="news?.category?.display_name"></p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Konten</label>
                            <div class="mt-1 text-sm text-gray-900 max-h-40 overflow-y-auto" x-html="news?.content"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <p class="mt-1 text-sm text-gray-900" x-text="news?.status_label"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penulis</label>
                                <p class="mt-1 text-sm text-gray-900" x-text="news?.author?.name"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Views</label>
                                <p class="mt-1 text-sm text-gray-900" x-text="news?.views"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    [x-cloak] { display: none !important; }
</style>

@endsection
