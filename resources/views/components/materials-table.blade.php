@props([
    'materials' => collect(),
    'showActions' => true,
    'showUploader' => true,
    'showCreateButton' => false,
    'createRoute' => null,
    'createButtonText' => 'Tambah Materi'
])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    @if($showCreateButton && $createRoute)
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Daftar Materi</h2>
            <a href="{{ $createRoute }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-plus mr-2"></i>
                {{ $createButtonText }}
            </a>
        </div>
    </div>
    @endif

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

    <!-- Responsive Table Container -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-2 sm:px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <span class="hidden sm:inline">Materi</span>
                        <span class="sm:hidden">Info</span>
                    </th>
                    <th class="hidden md:table-cell px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="hidden lg:table-cell px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyelenggara</th>
                    <th class="hidden sm:table-cell px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kegiatan</th>
                    <th class="hidden lg:table-cell px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th class="hidden md:table-cell px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Files</th>
                    @if($showUploader)
                    <th class="hidden lg:table-cell px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploader</th>
                    @endif
                    @if($showActions)
                    <th class="px-2 sm:px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($materials as $material)
                <tr class="hover:bg-gray-50">
                    <!-- Material Info Column (Always visible) -->
                    <td class="px-2 sm:px-3 py-3">
                        <div class="flex flex-col space-y-1">
                            <!-- Title -->
                            <div class="text-sm font-medium text-gray-900 truncate max-w-48 sm:max-w-64" title="{{ $material->title }}">
                                {{ $material->title }}
                            </div>
                            
                            <!-- Source -->
                            <div class="text-sm text-gray-500 truncate max-w-48 sm:max-w-64" title="{{ $material->source }}">
                                {{ $material->source }}
                            </div>
                            
                            <!-- Mobile: Show category and organizer -->
                            <div class="md:hidden space-y-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $material->category_label }}
                                </span>
                                <div class="text-xs text-gray-500 truncate max-w-40" title="{{ $material->organizer }}">
                                    {{ $material->organizer }}
                                </div>
                            </div>
                            
                            <!-- Mobile: Show activity date -->
                            <div class="sm:hidden text-xs text-gray-500">
                                {{ $material->display_activity_date }}
                            </div>
                            
                            <!-- Mobile: Show file count -->
                            <div class="md:hidden text-xs text-gray-500">
                                <span class="font-medium">{{ $material->file_count }}</span> file(s)
                            </div>
                        </div>
                    </td>
                    
                    <!-- Category Column (Hidden on mobile) -->
                    <td class="hidden md:table-cell px-3 py-3 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                            {{ $material->category_label }}
                        </span>
                    </td>
                    
                    <!-- Organizer Column (Hidden on mobile/tablet) -->
                    <td class="hidden lg:table-cell px-3 py-3 text-sm text-gray-900">
                        <div class="truncate max-w-40" title="{{ $material->organizer }}">{{ $material->organizer }}</div>
                    </td>
                    
                    <!-- Activity Date Column (Hidden on mobile) -->
                    <td class="hidden sm:table-cell px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                        {{ $material->display_activity_date }}
                    </td>
                    
                    <!-- Created Date Column (Hidden on mobile/tablet) -->
                    <td class="hidden lg:table-cell px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                        {{ $material->created_at->format('d M Y') }}
                    </td>
                    
                    <!-- Files Column (Hidden on mobile) -->
                    <td class="hidden md:table-cell px-3 py-3 whitespace-nowrap">
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
                    
                    <!-- Uploader Column (Hidden on mobile/tablet) -->
                    @if($showUploader)
                    <td class="hidden lg:table-cell px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                        {{ $material->uploader->name }}
                    </td>
                    @endif
                    
                    <!-- Actions Column -->
                    @if($showActions)
                    <td class="px-2 sm:px-3 py-3 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button @click="openModal({{ $material->id }})" class="text-indigo-600 hover:text-indigo-900" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if($showCreateButton)
                            <a href="{{ route('materials.edit', $material) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $showActions ? ($showUploader ? 8 : 7) : ($showUploader ? 7 : 6) }}" class="px-3 py-3 text-center text-gray-500">
                        Belum ada materi yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
