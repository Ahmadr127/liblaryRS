@extends('layouts.landing')

@section('title', $material->title . ' - Digital Library RS')

@section('content')
<div x-data="materialDetail()" class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('landing') }}" class="hover:text-teal-600">Beranda</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('public.materials') }}" class="hover:text-teal-600">Materi</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-900 font-medium">{{ $material->title }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Two-column layout: 70% left, 30% right -->
        <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
            <!-- Left Column (70%) -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Header Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <!-- Status and Actions -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-arrow-up text-teal-600 text-xl"></i>
                                </div>
                                <span 
                                    class="px-4 py-2 rounded-full text-sm font-medium {{ $statusClass }}"
                                >
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>

                        <!-- Title and Description -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $material->title }}</h1>
                        <p class="text-lg text-gray-600 mb-4">{{ $material->source }}</p>
                        
                        @if($material->context)
                        <div class="mb-6">
                            <!-- <h3 class="text-sm font-medium text-gray-700 mb-2">Konteks:</h3> -->
                            <div class="prose max-w-none text-gray-700">
                                {!! $material->context !!}
                            </div>
                        </div>
                        @endif

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                Akan berlangsung
                            </span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                Sumber: {{ $material->source }}
                            </span>
                            @if($material->category)
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">
                                {{ $material->category->display_name }}
                            </span>
                            @endif
                        </div>

                        <!-- Meta Information Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-alt text-teal-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Pelaksanaan</div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $material->display_activity_date }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-building text-teal-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Penyelenggara</div>
                                    <div class="text-sm font-medium text-gray-900">{{ $material->organizer ?? 'Tidak disebutkan' }}</div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-teal-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Uploader</div>
                                    <div class="text-sm font-medium text-gray-900">{{ $material->uploader->name ?? 'Administrator' }}</div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-clock text-teal-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Dipublikasi</div>
                                    <div class="text-sm font-medium text-gray-900">{{ $material->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                @if($material->description)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $material->description !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column (30%) -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Files Card -->
                @if($material->files->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">
                            File Materi ({{ $material->files->count() }})
                        </h2>
                    </div>

                    <div class="space-y-3">
                        @foreach($material->files as $file)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-file-pdf text-red-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ $file->original_name }}</h3>
                                    <div class="flex items-center space-x-4 text-xs text-gray-500 mt-1">
                                        <span>{{ number_format($file->file_size / 1024, 0) }} KB</span>
                                        <span>PDF</span>
                                        <span>Diupload {{ $file->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('materials.files.preview', $file) }}" target="_blank" class="p-2 text-gray-400 hover:text-teal-600 rounded-lg hover:bg-white" title="Lihat File">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('materials.files.download', $file) }}" class="p-2 text-gray-400 hover:text-teal-600 rounded-lg hover:bg-white" title="Unduh File">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Related Materials -->
                @if($relatedMaterials->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Materi Terkait</h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($relatedMaterials as $related)
                        <a href="{{ route('public.material.detail', $related) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-file-alt text-teal-600 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 line-clamp-2 mb-1">{{ $related->title }}</h3>
                                    <p class="text-xs text-gray-600">{{ $related->source }}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Share Modal -->
    <div x-show="shareModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="shareModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="shareModal = false"></div>

            <div x-show="shareModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-md p-6 my-8 text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Bagikan Materi</h3>
                    <button @click="shareModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Materi</label>
                        <div class="flex">
                            <input type="text" :value="shareUrl" readonly class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-teal-500 focus:border-teal-500 text-sm">
                            <button @click="copyToClipboard()" class="px-4 py-2 bg-teal-600 text-white rounded-r-lg hover:bg-teal-700 transition-colors">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <div x-show="copied" x-transition class="text-sm text-green-600 mt-1">Link berhasil disalin!</div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button @click="shareToWhatsApp()" class="flex items-center justify-center px-4 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fab fa-whatsapp mr-2"></i>
                            WhatsApp
                        </button>
                        <button @click="shareToEmail()" class="flex items-center justify-center px-4 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-envelope mr-2"></i>
                            Email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('materialDetail', () => ({
        shareModal: false,
        copied: false,
        shareUrl: window.location.href,



        copyToClipboard() {
            navigator.clipboard.writeText(this.shareUrl).then(() => {
                this.copied = true;
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            });
        },

        shareToWhatsApp() {
            const text = `Lihat materi pembelajaran: {{ $material->title }} - ${this.shareUrl}`;
            window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
        },

        shareToEmail() {
            const subject = `Materi Pembelajaran: {{ $material->title }}`;
            const body = `Saya ingin berbagi materi pembelajaran ini dengan Anda:\n\n{{ $material->title }}\n{{ $material->source }}\n\nLink: ${this.shareUrl}`;
            window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        }
    }));
});
</script>

<style>
[x-cloak] { display: none !important; }

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    line-height: 1.6;
}

.prose p {
    margin-bottom: 1rem;
}
</style>
@endsection
