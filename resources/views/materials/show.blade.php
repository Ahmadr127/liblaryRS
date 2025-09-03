@extends('layouts.app')

@section('title', 'Detail Materi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Detail Materi</h3>
                <div class="flex space-x-3">
                    <a href="{{ route('materials.edit', $material) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Kategori -->
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-500 w-24">Kategori:</span>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                    @if($material->category === 'medis') bg-blue-100 text-blue-800
                    @elseif($material->category === 'keperawatan') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ $material->category_label }}
                </span>
            </div>

            <!-- Judul -->
            <div class="flex items-start space-x-4">
                <span class="text-sm font-medium text-gray-500 w-24">Judul:</span>
                <div class="flex-1">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $material->title }}</h2>
                </div>
            </div>

            <!-- Penyelenggara -->
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-500 w-24">Penyelenggara:</span>
                <span class="text-gray-900">{{ $material->organizer }}</span>
            </div>

            <!-- Sumber -->
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-500 w-24">Sumber:</span>
                <span class="text-gray-900">{{ $material->source }}</span>
            </div>

            <!-- Tanggal Kegiatan -->
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-500 w-24">Tanggal:</span>
                <span class="text-gray-900">{{ $material->activity_date->format('d F Y') }}</span>
            </div>

            <!-- Uploader -->
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-500 w-24">Uploader:</span>
                <span class="text-gray-900">{{ $material->uploader->name }}</span>
            </div>

            <!-- Files -->
            <div class="flex items-start space-x-4">
                <span class="text-sm font-medium text-gray-500 w-24">Files:</span>
                <div class="flex-1">
                    @if($material->files->count() > 0)
                        <div class="space-y-3">
                            @foreach($material->files as $file)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $file->original_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $file->formatted_size }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('materials.download', $file) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        <i class="fas fa-download mr-1"></i>
                                        Download
                                    </a>
                                    @if(Auth::id() === $material->uploaded_by || Auth::user()->hasPermission('manage_materials'))
                                    <form action="{{ route('materials.deleteFile', $file) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus file ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-gray-500">Tidak ada file</span>
                    @endif
                </div>
            </div>

            <!-- Created/Updated -->
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-500 w-24">Dibuat:</span>
                <span class="text-gray-900">{{ $material->created_at->format('d F Y H:i') }}</span>
            </div>

            @if($material->updated_at != $material->created_at)
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-500 w-24">Diupdate:</span>
                <span class="text-gray-900">{{ $material->updated_at->format('d F Y H:i') }}</span>
            </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="px-6 py-4 border-t border-gray-200">
            <a href="{{ route('materials.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection
