@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Materi</h2>
                <a href="{{ route('materials.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Materi
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyelenggara</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
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
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($material->category === 'medis') bg-blue-100 text-blue-800
                                @elseif($material->category === 'keperawatan') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $material->category_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $material->organizer }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $material->activity_date->format('d M Y') }}
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
                                <a href="{{ route('materials.show', $material) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('materials.edit', $material) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
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
</div>
@endsection
