<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="images/logo.png">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Digital Liblary RS')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Styles & Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        html { scroll-behavior: smooth; }
        .gradient-bg {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        }
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        /* Enhanced sticky navbar */
        .sticky-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Fallback for browsers without backdrop-filter support */
        @supports not (backdrop-filter: blur(12px)) {
            .sticky-navbar {
                background-color: rgba(255, 255, 255, 0.95);
            }
        }
    </style>
</head>
<body x-data="{ mobileMenuOpen: false, showSearch: false }" class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <header id="mainHeader" class="bg-white/95 backdrop-blur-md fixed top-0 left-0 right-0 z-50 shadow-sm border-b border-gray-200 transition-all duration-300 h-16" x-data="{ scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })" :class="{ 'shadow-lg bg-white': scrolled }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex justify-between items-center h-full">
                <!-- Logo & Navigation -->
                <div class="flex items-center space-x-8">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-md object-contain bg-white">
                        <div class="hidden sm:block leading-tight">
                            <h1 class="text-lg font-bold text-gray-900">Digital Liblary</h1>
                            <p class="text-xs text-gray-600">Rumah Sakit Azra</p>
                        </div>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('landing') }}" class="text-gray-700 hover:text-teal-600 font-medium transition-colors">Beranda</a>
                        <a href="/materials" class="text-gray-700 hover:text-teal-600 font-medium transition-colors">Materi</a>
                        <a href="{{ route('public.news.index') }}" class="text-gray-700 hover:text-teal-600 font-medium transition-colors">Berita</a>
                        <a href="{{ route('about') }}" class="text-gray-700 hover:text-teal-600 font-medium transition-colors">Tentang</a>
                    </nav>
                </div>

                <!-- Search (Desktop) -->
                <div class="hidden md:block flex-1 max-w-2xl mx-4 min-w-0">
                    <form action="{{ route('landing') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi pembelajaran..." 
                               class="w-full px-5 py-2 pl-11 pr-24 rounded-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                        <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 bg-teal-600 text-white px-4 py-1.5 rounded-full hover:bg-teal-700 text-sm">
                            Cari
                        </button>
                    </form>
                </div>

                <!-- Auth Button -->
                <div class="hidden sm:flex items-center">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-teal-600 border border-teal-600 rounded-lg hover:bg-teal-50 transition-colors font-medium">
                        Masuk
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-teal-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                <!-- Mobile search toggle -->
                <div class="md:hidden">
                    <button @click="showSearch = !showSearch" class="ml-3 text-gray-700 hover:text-teal-600" aria-label="Toggle search">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile inline search -->
            <div x-show="showSearch" x-transition class="md:hidden border-t border-gray-200 py-3">
                <form action="{{ route('landing') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi pembelajaran..." 
                           class="w-full px-4 py-2 pl-10 pr-24 rounded-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                    <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 bg-teal-600 text-white px-4 py-1.5 rounded-full hover:bg-teal-700 text-sm">
                        Cari
                    </button>
                </form>
            </div>
            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-gray-200 py-4">
                <div class="mb-3">
                    <form action="{{ route('landing') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi pembelajaran..." 
                               class="w-full px-4 py-2 pl-10 pr-24 rounded-full border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                        <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 bg-teal-600 text-white px-4 py-1.5 rounded-full hover:bg-teal-700 text-sm">
                            Cari
                        </button>
                    </form>
                </div>
                <nav class="flex flex-col space-y-4">
                    <a href="{{ route('landing') }}" class="text-gray-700 hover:text-teal-600 font-medium">Beranda</a>
                    <a href="/materials" class="text-gray-700 hover:text-teal-600 font-medium">Materi</a>
                    <a href="{{ route('public.news.index') }}" class="text-gray-700 hover:text-teal-600 font-medium">Berita</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-teal-600 font-medium">Tentang</a>
                    <div class="flex flex-col space-y-2 pt-4 border-t border-gray-200">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-teal-600 border border-teal-600 rounded-lg text-center">Masuk</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo & Description -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-teal-600 to-teal-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book-medical text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold">Digital Liblary RS</h3>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Platform digital untuk mengelola dan mengakses materi pembelajaran, 
                        dokumen medis, dan sumber daya edukatif di lingkungan rumah sakit.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#materials" class="text-gray-400 hover:text-white transition-colors">Materi</a></li>
                        <li><a href="#categories" class="text-gray-400 hover:text-white transition-colors">Kategori</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">Tentang</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-envelope"></i>
                            <span>https://rsazra.co.id/</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-phone"></i>
                            <span>-</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Digital Liblary RS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Enforce fixed header in case of browser quirks
        (function() {
            try {
                const header = document.getElementById('mainHeader');
                if (header) {
                    header.style.position = 'fixed';
                    header.style.top = '0';
                    header.style.left = '0';
                    header.style.right = '0';
                }
                document.documentElement.style.overflowY = 'auto';
                document.body.style.overflowY = 'auto';
            } catch (e) {}
        })();
        document.addEventListener('alpine:init', () => {
            Alpine.data('landing', () => ({
                mobileMenuOpen: false,
                currentDate: new Date(),
                selectedDate: null,
                calendarDays: [],
                filteredMaterials: [],
                allMaterials: [],
                calendarMaterials: [],
                sections: ['section-news','section-materials','section-calendar','section-about'],
                currentSectionIndex: 0,
                isAtBottom: false,

                // Helper: format Date to YYYY-MM-DD in local timezone (avoid UTC shift)
                formatDate(dateObj) {
                    const y = dateObj.getFullYear();
                    const m = String(dateObj.getMonth() + 1).padStart(2, '0');
                    const d = String(dateObj.getDate()).padStart(2, '0');
                    return `${y}-${m}-${d}`;
                },

                // Compute status label and classes based on date(s)
                statusFor(material) {
                    const today = this.formatDate(new Date());
                    const start = material.activity_date_start || material.activity_date || null;
                    const end = material.activity_date_end || material.activity_date || null;
                    if (!start && !end) {
                        return { label: 'Tidak terjadwal', cls: 'bg-gray-200 text-gray-700' };
                    }
                    if (start && today < start) {
                        return { label: 'Akan berlangsung', cls: 'bg-blue-100 text-blue-700' };
                    }
                    if (end && today > end) {
                        return { label: 'Sudah berlangsung', cls: 'bg-gray-300 text-gray-800' };
                    }
                    return { label: 'Sedang berlangsung', cls: 'bg-orange-500 text-white' };
                },

                get currentMonthYear() {
                    try {
                        return this.currentDate.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
                    } catch (e) {
                        return 'Januari 2025';
                    }
                },

                get selectedDateText() {
                    if (!this.selectedDate) return 'Pilih tanggal untuk melihat jadwal';
                    try {
                        return new Date(this.selectedDate).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    } catch (e) {
                        return 'Pilih tanggal untuk melihat jadwal';
                    }
                },

                init() {
                    // Pull data injected from Blade if available
                    if (window.__LANDING_DATA && Array.isArray(window.__LANDING_DATA.materials)) {
                        this.allMaterials = window.__LANDING_DATA.materials;
                        this.calendarMaterials = this.allMaterials;
                    }
                    this.generateCalendar();
                    this.loadMaterialsForDate();
                    this.updateScrollState();
                    window.addEventListener('scroll', () => this.updateScrollState());
                    window.addEventListener('resize', () => this.updateScrollState());
                },

                // Floating nav helpers
                scrollToTop() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    this.currentSectionIndex = 0;
                },

                scrollToNextSection() {
                    try {
                        const idx = Math.min(this.currentSectionIndex + 1, this.sections.length - 1);
                        const id = this.sections[idx];
                        const el = document.getElementById(id);
                        if (el) {
                            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            this.currentSectionIndex = idx;
                        }
                    } catch (e) {}
                },

                updateScrollState() {
                    try {
                        const scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
                        const viewport = window.innerHeight || document.documentElement.clientHeight;
                        const full = document.documentElement.scrollHeight;
                        this.isAtBottom = scrollTop + viewport >= full - 2;
                    } catch (e) {
                        this.isAtBottom = false;
                    }
                },

                generateCalendar() {
                    try {
                        const year = this.currentDate.getFullYear();
                        const month = this.currentDate.getMonth();
                        const firstDay = new Date(year, month, 1);
                        // Make Monday the first day of week: convert JS getDay() (0=Sun..6=Sat) to Mon=0..Sun=6
                        const firstDayIndexMonday = (firstDay.getDay() + 6) % 7;
                        const startDate = new Date(year, month, 1 - firstDayIndexMonday);

                        this.calendarDays = [];
                        for (let i = 0; i < 42; i++) {
                            const date = new Date(startDate);
                            date.setDate(startDate.getDate() + i);
                            const dateStr = this.formatDate(date);
                            const hasEvents = Array.isArray(this.calendarMaterials) && this.calendarMaterials.some(material => {
                                if (material.activity_date === dateStr) return true;
                                if (material.activity_date_start && material.activity_date_end) {
                                    return dateStr >= material.activity_date_start && dateStr <= material.activity_date_end;
                                }
                                return false;
                            });
                            this.calendarDays.push({
                                day: date.getDate(),
                                date: dateStr,
                                isCurrentMonth: date.getMonth() === month,
                                isSelected: this.selectedDate === dateStr,
                                hasEvents
                            });
                        }
                    } catch (e) {
                        console.error('generateCalendar error', e);
                        this.calendarDays = [];
                    }
                },

                selectDate(date) {
                    this.selectedDate = date;
                    this.generateCalendar();
                    this.loadMaterialsForDate();
                },

                loadMaterialsForDate() {
                    if (!this.selectedDate) {
                        this.filteredMaterials = Array.isArray(this.allMaterials) ? this.allMaterials : [];
                        return;
                    }
                    this.filteredMaterials = (Array.isArray(this.allMaterials) ? this.allMaterials : []).filter(material => {
                        if (material.activity_date === this.selectedDate) return true;
                        if (material.activity_date_start && material.activity_date_end) {
                            return this.selectedDate >= material.activity_date_start && this.selectedDate <= material.activity_date_end;
                        }
                        return false;
                    });
                },

                previousMonth() {
                    this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                    this.generateCalendar();
                },

                nextMonth() {
                    this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                    this.generateCalendar();
                }
            }));
        });
    </script>
</body>
</html>
