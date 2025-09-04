@extends('layouts.landing')

@section('title', 'Digital Liblary RS - Materi Pembelajaran')

@section('content')
<script>
    window.__LANDING_DATA = {
        materials: @json($calendarMaterials ?? [])
    };
</script>

<div x-data="landing()" x-init="init()" class="relative">
    <div class="relative z-10">
        @include('components.hero', ['materials' => $materials, 'categories' => $categories, 'recentMaterials' => $recentMaterials])
    </div>

    <div class="relative z-20">
        @include('components.calendar-schedule')
    </div>

    <div class="relative z-30">
        @include('components.about')
    </div>
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Ensure hero section is visible and backgrounds work properly */
    .hero-section {
        position: relative !important;
        z-index: 1 !important;
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 25%, #14b8a6 75%, #5eead4 100%) !important;
    }
    
    /* Hero pattern background */
    .hero-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") !important;
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
</style>
@endsection
