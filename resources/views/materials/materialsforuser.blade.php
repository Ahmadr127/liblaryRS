@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
<div class="w-full mx-auto" x-data="{
    isOpen: false,
    loading: false,
    material: null,
    ...tableFilter({
        search: '{{ request('search') }}',
        category_id: '{{ request('category_id') }}',
        dateFrom: '{{ request('date_from') }}',
        dateTo: '{{ request('date_to') }}'
    }),
    
    async openModal(materialId) {
        this.isOpen = true;
        this.loading = true;
        this.material = null;
        
        try {
            console.log('Loading material details for ID:', materialId);
            const response = await fetch(`/materials/${materialId}/modal`);
            if (response.ok) {
                this.material = await response.json();
                console.log('Material data loaded:', this.material);
            } else {
                console.error('Failed to load material details:', response.status, response.statusText);
            }
        } catch (error) {
            console.error('Error loading material details:', error);
        } finally {
            this.loading = false;
        }
    },
    
    closeModal() {
        this.isOpen = false;
        this.material = null;
    }
}">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Materi</h2>
            </div>
        </div>

        <!-- Table Filter Component -->
        <x-table-filter 
            :show-category-filter="true"
            :categories="$categories->map(fn($c) => ['value' => $c->id, 'label' => $c->display_name])->toArray()"
        />

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyelenggara</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kegiatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Files</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploader</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($materials as $material)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $material->title }}</div>
                            <div class="text-sm text-gray-500">{{ $material->source }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $material->category_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $material->organizer }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $material->activity_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $material->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <span class="font-medium">{{ $material->file_count }}</span> file(s)
                            </div>
                            @if($material->files->count() > 0)
                            <div class="text-xs text-gray-500 mt-1">
                                @foreach($material->files->take(2) as $file)
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-file-pdf text-red-500"></i>
                                        <span class="truncate max-w-32">{{ $file->original_name }}</span>
                                    </div>
                                @endforeach
                                @if($material->files->count() > 2)
                                    <div class="text-gray-400">+{{ $material->files->count() - 2 }} more</div>
                                @endif
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $material->uploader->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button @click="openModal({{ $material->id }})" class="text-indigo-600 hover:text-indigo-900" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            Belum ada materi yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($materials->hasPages())
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $materials->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Component -->
    <x-modal-detail-materials />
</div>

@endsection
