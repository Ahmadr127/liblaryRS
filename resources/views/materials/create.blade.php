@extends('layouts.app')

@section('title', 'Tambah Materi Baru')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Tambah Materi Baru</h3>
        </div>

        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6" x-data="{ dateType: 'single' }" @submit="handleFormSubmit">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select id="category_id" name="category_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->display_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Kegiatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kegiatan *</label>
                    
                    <!-- Toggle untuk pilih jenis tanggal -->
                    <div class="mb-3">
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="date_type" value="single" x-model="dateType" class="mr-2">
                                <span class="text-sm text-gray-700">Tanggal Tunggal</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="date_type" value="range" x-model="dateType" class="mr-2">
                                <span class="text-sm text-gray-700">Rentang Tanggal</span>
                            </label>
                        </div>
                    </div>

                    <!-- Input Tanggal Tunggal -->
                    <div x-show="dateType === 'single'" class="mb-3">
                        <input type="date" id="activity_date" name="activity_date" value="{{ old('activity_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                        @error('activity_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Rentang Tanggal -->
                    <div x-show="dateType === 'range'" class="space-y-3">
                        <div>
                            <label for="activity_date_start" class="block text-sm font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                            <input type="date" id="activity_date_start" name="activity_date_start" value="{{ old('activity_date_start') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                            @error('activity_date_start')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="activity_date_end" class="block text-sm font-medium text-gray-600 mb-1">Tanggal Selesai</label>
                            <input type="date" id="activity_date_end" name="activity_date_end" value="{{ old('activity_date_end') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                            @error('activity_date_end')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Judul -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Materi *</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" placeholder="Masukkan judul materi">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Penyelenggara -->
                <div>
                    <label for="organizer" class="block text-sm font-medium text-gray-700 mb-2">Penyelenggara *</label>
                    <input type="text" id="organizer" name="organizer" value="{{ old('organizer') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" placeholder="Masukkan nama penyelenggara">
                    @error('organizer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sumber -->
                <div>
                    <label for="source" class="block text-sm font-medium text-gray-700 mb-2">Sumber *</label>
                    <input type="text" id="source" name="source" value="{{ old('source') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" placeholder="Masukkan sumber materi">
                    @error('source')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- File Upload -->
            <div x-data="fileUpload()">
                <label for="file" class="block text-sm font-medium text-gray-700 mb-2">File PDF *</label>
                
                <!-- Drag & Drop Zone -->
                <div 
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    @drop.prevent="handleDrop($event)"
                    @click="$refs.fileInput.click()"
                    :class="isDragging ? 'border-green-500 bg-green-50' : 'border-gray-300'"
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md cursor-pointer transition-colors hover:border-green-400 hover:bg-green-50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500">
                                <span>Upload file</span>
                                <input 
                                    x-ref="fileInput"
                                    id="file" 
                                    name="file[]" 
                                    type="file" 
                                    accept=".pdf" 
                                    class="sr-only" 
                                    required 
                                    multiple
                                    @change="handleFileSelect($event)">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF hingga 10MB per file. Bisa upload multiple file.</p>
                    </div>
                </div>

                <!-- Selected Files Display -->
                <div x-show="selectedFiles.length > 0" class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">File yang dipilih:</h4>
                    <div class="space-y-2">
                        <template x-for="(file, index) in selectedFiles" :key="index">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    <span x-text="file.name" class="text-sm text-gray-900"></span>
                                    <span x-text="formatFileSize(file.size)" class="text-xs text-gray-500"></span>
                                </div>
                                <button 
                                    @click="removeFile(index)" 
                                    type="button"
                                    class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('materials.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Materi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function fileUpload() {
    return {
        isDragging: false,
        selectedFiles: [],
        
        handleFileSelect(event) {
            const files = Array.from(event.target.files);
            this.addFiles(files);
            this.updateFileInput();
        },
        
        handleDrop(event) {
            this.isDragging = false;
            const files = Array.from(event.dataTransfer.files);
            this.addFiles(files);
            this.updateFileInput();
        },
        
        addFiles(files) {
            console.log('Adding files:', files.length, 'files');
            files.forEach(file => {
                console.log('Processing file:', file.name, 'Type:', file.type, 'Size:', file.size);
                if (file.type === 'application/pdf' && file.size <= 10 * 1024 * 1024) {
                    // Check if file already exists
                    const exists = this.selectedFiles.some(existingFile => 
                        existingFile.name === file.name && existingFile.size === file.size
                    );
                    if (!exists) {
                        this.selectedFiles.push(file);
                        console.log('File added:', file.name);
                    } else {
                        console.log('File already exists:', file.name);
                    }
                } else {
                    console.log('Invalid file:', file.name, 'Type:', file.type, 'Size:', file.size);
                    alert(`File ${file.name} tidak valid. Hanya file PDF dengan ukuran maksimal 10MB yang diperbolehkan.`);
                }
            });
            console.log('Total selected files:', this.selectedFiles.length);
        },
        
        removeFile(index) {
            this.selectedFiles.splice(index, 1);
            this.updateFileInput();
        },
        
        updateFileInput() {
            const fileInput = this.$refs.fileInput;
            
            try {
                // Create a new FileList-like object using DataTransfer API
                const dataTransfer = new DataTransfer();
                
                this.selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                
                // Update the file input
                fileInput.files = dataTransfer.files;
                
                // Trigger change event to ensure form validation works
                fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                
                console.log('Files updated:', fileInput.files.length, 'files selected');
            } catch (error) {
                console.error('Error updating file input:', error);
                // Fallback: just trigger the change event
                fileInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
        },
        
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },
        
        handleFormSubmit(event) {
            const fileInput = this.$refs.fileInput;
            console.log('Form submitting with files:', fileInput.files.length);
            console.log('Selected files array:', this.selectedFiles.length);
            
            // Ensure files are properly set
            if (this.selectedFiles.length > 0 && fileInput.files.length === 0) {
                console.warn('Files not properly set in input, attempting to fix...');
                this.updateFileInput();
            }
        }
    }
}
</script>
@endsection
