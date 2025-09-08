@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div x-data="materialsModal()" class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang, {{ $user->name }}!</h2>
            <p class="text-gray-600">Dashboard Library RS - Sistem Manajemen Materi Perpustakaan</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Materials Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Total Materi</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalMaterials }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Files Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-pdf text-2xl text-red-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Total Files</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalFiles }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medis Materials Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-stethoscope text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Materi Medis</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $medisCount }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keperawatan Materials Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-nurse text-2xl text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Materi Keperawatan</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $keperawatanCount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Materials and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Materials Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Materi Terbaru</h3>
                    <a href="{{ route('materials.index') }}" class="text-green-600 hover:text-green-900 text-sm font-medium">
                        Lihat semua →
                    </a>
                </div>
                
                @if($recentMaterials->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentMaterials as $material)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate">{{ $material->title }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $material->category_label }} • {{ $material->uploader->name }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $material->file_count }} file(s) • {{ $material->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 ml-3">
                                <button @click="openModal({{ $material->id }})" class="p-2 text-teal-600 hover:text-teal-900 hover:bg-teal-50 rounded-md transition-colors" title="Lihat cepat">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('materials.show', $material) }}" class="p-2 text-green-600 hover:text-green-900 hover:bg-green-50 rounded-md transition-colors" title="Lihat halaman">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @if($user->hasPermission('manage_materials'))
                                <a href="{{ route('materials.edit', $material) }}" class="p-2 text-yellow-600 hover:text-yellow-900 hover:bg-yellow-50 rounded-md transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-book text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 mb-4">Belum ada materi yang ditambahkan.</p>
                        @if($user->hasPermission('manage_materials'))
                        <a href="{{ route('materials.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Materi Pertama
                        </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    @if($user->hasPermission('manage_materials'))
                    <a href="{{ route('materials.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus text-white"></i>
                        </div>
                        <div>
                            <div class="text-green-900 font-medium">Tambah Materi Baru</div>
                            <div class="text-sm text-green-600">Upload materi baru ke sistem</div>
                        </div>
                    </a>
                    @endif
                    
                    <a href="{{ route('materials.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                        <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center mr-4 group-hover:bg-gray-700 transition-colors">
                            <i class="fas fa-list text-white"></i>
                        </div>
                        <div>
                            <div class="text-gray-900 font-medium">Lihat Semua Materi</div>
                            <div class="text-sm text-gray-600">Kelola semua materi yang ada</div>
                        </div>
                    </a>
                    
                    @if($user->hasPermission('manage_materials'))
                    <a href="{{ route('materials.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-700 transition-colors">
                            <i class="fas fa-upload text-white"></i>
                        </div>
                        <div>
                            <div class="text-green-900 font-medium">Upload Multiple Files</div>
                            <div class="text-sm text-green-600">Upload beberapa file sekaligus</div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('components.modal-detail-materials')
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('materialsModal', () => ({
            isOpen: false,
            loading: false,
            material: null,
            async openModal(id) {
                this.isOpen = true;
                this.loading = true;
                this.material = null;
                try {
                    const response = await fetch(`/materials/${id}/modal`, { headers: { 'Accept': 'application/json' } });
                    if (!response.ok) throw new Error('Gagal memuat');
                    const data = await response.json();
                    this.material = data;
                } catch (e) {
                    console.error(e);
                    this.material = null;
                } finally {
                    this.loading = false;
                }
            },
            closeModal() {
                this.isOpen = false;
                this.material = null;
            }
        }));
    });
</script>
@endsection
