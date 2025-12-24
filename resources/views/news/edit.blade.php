@extends('layouts.app')

@section('title', 'Edit Berita')

@section('head')
<!-- Quill.js -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
@endsection

@section('content')
<div class="w-full">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <!-- Error Messages -->
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-md p-3 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Terjadi kesalahan
                        </h3>
                        <div class="mt-1 text-sm text-red-700">
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

            <!-- Layout 2 Kolom -->
            <div class="grid grid-cols-10 gap-6">
                <!-- Kolom Kiri (70%) -->
                <div class="col-span-7 space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               placeholder="Masukkan judul berita" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                            Konten Berita <span class="text-red-500">*</span>
                        </label>
                        <div id="content" class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror" style="height: 400px;">
                            {!! old('content', $news->content) !!}
                        </div>
                        <textarea name="content" id="content-hidden" style="display: none;"></textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Kolom Kanan (30%) -->
                <div class="col-span-3 space-y-4">
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="category_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->display_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror" required>
                            <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                            <option value="archived" {{ old('status', $news->status) == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published At -->
                    <div id="published-at-field" class="{{ old('status', $news->status) === 'published' ? '' : 'hidden' }}">
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Publikasi
                        </label>
                        <input type="datetime-local" name="published_at" id="published_at" 
                               value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('published_at') border-red-500 @enderror">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    @if($news->image)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Gambar Saat Ini
                        </label>
                        <div class="flex items-center space-x-3">
                            <img src="{{ $news->image_url }}" alt="{{ $news->image_alt }}" class="h-20 w-auto rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Gambar saat ini</p>
                                <p class="text-xs text-gray-500">Upload gambar baru untuk mengganti</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $news->image ? 'Ganti Gambar' : 'Gambar Utama' }}
                        </label>
                        <div class="flex justify-center px-4 pt-3 pb-4 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-400"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload gambar</span>
                                        <input id="image" name="image" type="file" accept="image/*" class="sr-only" onchange="previewImage(this)">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                            </div>
                        </div>
                        <div id="image-preview" class="mt-2 hidden">
                            <img id="preview-img" src="" alt="Preview" class="h-24 w-auto rounded-lg">
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- News Info -->
                    <div class="border-t pt-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Informasi Berita</h3>
                        
                        <div class="space-y-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Penulis</label>
                                <p class="text-sm text-gray-900">{{ $news->author->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Dibuat</label>
                                <p class="text-sm text-gray-900">{{ $news->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Views</label>
                                <p class="text-sm text-gray-900">{{ number_format($news->views) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t mt-6">
                <a href="{{ route('news.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Update Berita
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function formatDateTimeLocal(date) {
    const pad = (n) => String(n).padStart(2, '0');
    const y = date.getFullYear();
    const m = pad(date.getMonth() + 1);
    const d = pad(date.getDate());
    const h = pad(date.getHours());
    const i = pad(date.getMinutes());
    return `${y}-${m}-${d}T${h}:${i}`;
}

function ensureValidPublishedAt() {
    try {
        const statusEl = document.getElementById('status');
        const publishedAtEl = document.getElementById('published_at');
        if (!statusEl || !publishedAtEl) return;
        if (statusEl.value !== 'published') return;
        const now = new Date();
        if (!publishedAtEl.value) {
            publishedAtEl.value = formatDateTimeLocal(now);
            return;
        }
        const currentVal = new Date(publishedAtEl.value);
        if (isFinite(currentVal) && currentVal < now) {
            publishedAtEl.value = formatDateTimeLocal(now);
        }
    } catch (e) {}
}
// Initialize Quill.js
var quill = new Quill('#content', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['link'],
            ['clean']
        ]
    },
    placeholder: 'Tulis konten berita lengkap...'
});

// Initialize hidden textarea with current Quill content on page load
document.querySelector('#content-hidden').value = quill.root.innerHTML;

// Update hidden textarea in real-time as user types
quill.on('text-change', function() {
    document.querySelector('#content-hidden').value = quill.root.innerHTML;
});

// Update hidden textarea before form submission
document.querySelector('form').addEventListener('submit', function(e) {
    // Update the hidden textarea with Quill content
    document.querySelector('#content-hidden').value = quill.root.innerHTML;
    
    // Also update the original content div to ensure it has content
    if (quill.getText().trim() === '') {
        e.preventDefault();
        alert('Konten berita wajib diisi.');
        return false;
    }

    // Auto-set published_at to now if status is published and field empty
    try { ensureValidPublishedAt(); } catch (err) {}
});

function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}

// Show/hide published_at field based on status
document.getElementById('status').addEventListener('change', function() {
    const publishedAtField = document.getElementById('published-at-field');
    if (this.value === 'published') {
        publishedAtField.classList.remove('hidden');
        // Tidak otomatis mengisi saat user mengganti status; biarkan kosong sampai submit
    } else {
        publishedAtField.classList.add('hidden');
    }
});

</script>

@endsection
