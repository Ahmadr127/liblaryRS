@extends('layouts.landing')

@section('title', 'Tentang - Digital Library RS')

@section('content')
<div class="min-h-screen bg-gray-50">
 

    <!-- Highlight (icons) -->
    @include('components.about')

    <!-- Mission and Core Features -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-3">Misi Kami</h2>
                    <p class="text-gray-700 leading-relaxed">Memberikan akses mudah ke materi pembelajaran medis berkualitas untuk mendukung pengembangan profesional tenaga kesehatan di Rumah Sakit Azra.</p>
                </div>
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-3">Fitur Utama</h2>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-search text-teal-600 mt-1 mr-2"></i>
                            <span>Pencarian materi yang cepat dan akurat</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-calendar-alt text-teal-600 mt-1 mr-2"></i>
                            <span>Kalender kegiatan terintegrasi</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-folder-open text-teal-600 mt-1 mr-2"></i>
                            <span>Manajemen file materi yang rapi</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Call To Action -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-teal-600 to-teal-500 rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between text-white">
                <div class="mb-4 sm:mb-0">
                    <h3 class="text-xl font-semibold">Siap menjelajah materi pembelajaran?</h3>
                    <p class="text-white/90">Temukan materi terbaru dan terkurasi untuk kebutuhan Anda.</p>
                </div>
                <a href="{{ route('public.materials') }}" class="inline-flex items-center px-5 py-3 bg-white text-teal-700 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                    Jelajahi Materi
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection


