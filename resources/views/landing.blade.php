@extends('layouts.landing')

@section('title', 'Digital Liblary RS - Materi Pembelajaran')

@section('content')
<script>
    window.__LANDING_DATA = {
        materials: @json($calendarMaterials ?? []),
        allMaterials: @json($formattedMaterials ?? []),
        categories: @json($categories ?? [])
    };
</script>

<div x-data="landing()" x-init="init()" class="relative">
    <!-- News Section -->
    <div id="section-news" class="relative z-30">
        @include('components.news-section')
    </div>

    <!-- Materials Section -->
    <div id="section-materials" class="relative z-20 bg-white">
        @include('components.materials-section')
    </div>

    <!-- Calendar Section -->
    <div id="section-calendar" class="relative z-30">
        @include('components.calendar-schedule')
    </div>

    <!-- About Section -->
    <div id="section-about" class="relative z-30">
        @include('components.about')
    </div>

    <!-- Floating Navigation Buttons -->
    <div class="fixed right-5 bottom-5 z-50 flex flex-col gap-3">
        <button x-show="isAtBottom" x-transition @click="scrollToTop()" class="w-12 h-12 rounded-full bg-teal-600 text-white shadow-lg hover:bg-teal-700 flex items-center justify-center">
            <i class="fas fa-arrow-up"></i>
        </button>
        <button x-show="!isAtBottom" x-transition @click="scrollToNextSection()" class="w-12 h-12 rounded-full bg-gray-800 text-white shadow-lg hover:bg-gray-900 flex items-center justify-center">
            <i class="fas fa-arrow-down"></i>
        </button>
    </div>
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Section spacing tweaks */
    #section-news + #section-materials,
    #section-materials + #section-calendar,
    #section-calendar + #section-about {
        margin-top: -8px;
    }

    /* Fix any potential Alpine.js conflicts */
    [x-data] {
        position: relative;
    }
    
    /* Ensure proper stacking context */
    .relative {
        position: relative;
    }
    
    /* Override any conflicting Tailwind z-index */
    .z-10 { z-index: 10 !important; }
    .z-20 { z-index: 20 !important; }
    .z-30 { z-index: 30 !important; }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

@include('components.materials-section-script')
@endsection
