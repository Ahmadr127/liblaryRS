@props(['materials', 'categories', 'recentMaterials'])

<!-- Hero Section -->
<section class="hero-section relative overflow-hidden min-h-screen flex items-center" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 25%, #14b8a6 75%, #5eead4 100%); position: relative;">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10" style="z-index: 1;">
        <div class="absolute inset-0 hero-pattern"></div>
    </div>
    
    <!-- Background Overlay -->
    <div class="absolute inset-0" style="background: rgba(15, 118, 110, 0.1); z-index: 2;"></div>

    <!-- Hero Slider -->
    <div x-data="heroSlider()" class="w-full relative" style="z-index: 10;">
        <!-- Slides Container -->
        <div class="relative w-full h-screen" style="z-index: 15;">
            <!-- Slide 1: Main Hero -->
            <div x-show="currentSlide === 0" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                 class="absolute inset-0 flex items-center" style="z-index: 20;">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                        <!-- Content -->
                        <div class="text-white space-y-10 relative" style="z-index: 30;">
                            <div class="space-y-6">
                                <h1 class="text-5xl lg:text-6xl font-bold leading-tight drop-shadow-lg">
                                    Digital Library
                                    <span class="block text-teal-200">Rumah Sakit</span>
                                </h1>
                                <p class="text-xl lg:text-2xl text-teal-50 leading-relaxed drop-shadow-md">
                                    Akses materi pembelajaran medis terbaru dan terlengkap untuk pengembangan profesional tenaga kesehatan
                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-6 mt-8">
                                <a href="/materials" class="inline-flex items-center px-8 py-4 bg-teal-600 text-white font-semibold rounded-full hover:bg-teal-700 transition-all duration-300 transform hover:scale-105 shadow-xl">
                                    <i class="fas fa-book-medical mr-3 text-lg"></i>
                                    Jelajahi Materi
                                </a>
                                <a href="#about" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-teal-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-info-circle mr-3 text-lg"></i>
                                    Pelajari Lebih Lanjut
                                </a>
                            </div>
                        </div>
                        <!-- Image -->
                        <div class="relative mt-12 lg:mt-0">
                            <div class="relative z-30">
                                <img src="{{ asset('images/hero.jpg') }}" alt="Medical Education" class="w-full h-96 object-cover rounded-2xl shadow-2xl">
                            </div>
                            <!-- Floating Elements -->
                            <div class="absolute -top-4 -right-4 w-24 h-24 bg-teal-400 rounded-full opacity-30 animate-pulse"></div>
                            <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-teal-300 rounded-full opacity-40 animate-pulse delay-1000"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Features -->
            <div x-show="currentSlide === 1" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                 class="absolute inset-0 flex items-center" style="z-index: 20;">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="text-center text-white space-y-20 relative" style="z-index: 30;">
                        <div class="space-y-10">
                            <h2 class="text-5xl lg:text-6xl font-bold drop-shadow-lg">
                                Fitur Unggulan
                            </h2>
                            <p class="text-xl lg:text-2xl text-teal-50 max-w-3xl mx-auto mb-4 drop-shadow-md">
                                Platform digital yang dirancang khusus untuk kebutuhan edukasi medis modern
                            </p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 px-4">
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-8 border border-white/30 hover:bg-white/30 transition-all duration-300 transform hover:scale-105 shadow-xl">
                                <div class="w-16 h-16 bg-teal-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <i class="fas fa-search text-2xl text-white"></i>
                                </div>
                                <h3 class="text-xl font-semibold mb-4 text-white">Pencarian Cerdas</h3>
                                <p class="text-teal-50">Temukan materi dengan cepat menggunakan sistem pencarian yang canggih</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-8 border border-white/30 hover:bg-white/30 transition-all duration-300 transform hover:scale-105 shadow-xl">
                                <div class="w-16 h-16 bg-teal-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <i class="fas fa-calendar-alt text-2xl text-white"></i>
                                </div>
                                <h3 class="text-xl font-semibold mb-4 text-white">Jadwal Terintegrasi</h3>
                                <p class="text-teal-50">Kelola jadwal pembelajaran dengan kalender yang mudah digunakan</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-8 border border-white/30 hover:bg-white/30 transition-all duration-300 transform hover:scale-105 shadow-xl">
                                <div class="w-16 h-16 bg-teal-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <i class="fas fa-users text-2xl text-white"></i>
                                </div>
                                <h3 class="text-xl font-semibold mb-4 text-white">Kolaborasi Tim</h3>
                                <p class="text-teal-50">Berkolaborasi dengan tim medis untuk pengembangan bersama</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Statistics -->
            <div x-show="currentSlide === 2" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                 class="absolute inset-0 flex items-center" style="z-index: 20;">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                        <!-- Content -->
                        <div class="text-white space-y-12 relative" style="z-index: 30;">
                            <div class="space-y-8">
                                <h2 class="text-5xl lg:text-6xl font-bold leading-tight drop-shadow-lg">
                                    Platform Terpercaya
                                </h2>
                                <p class="text-xl lg:text-2xl text-teal-50 leading-relaxed drop-shadow-md mb-4">
                                    Digunakan oleh ribuan tenaga kesehatan untuk pengembangan profesional yang berkelanjutan
                                </p>
                            </div>
                            <div class="grid grid-cols-2 gap-10 mt-12">
                                <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                                    <div class="text-4xl font-bold text-teal-200 mb-2 drop-shadow-lg" x-text="stats.materials">0</div>
                                    <div class="text-teal-50 font-medium">Materi Pembelajaran</div>
                                </div>
                                <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                                    <div class="text-4xl font-bold text-teal-200 mb-2 drop-shadow-lg" x-text="stats.categories">0</div>
                                    <div class="text-teal-50 font-medium">Kategori</div>
                                </div>
                                <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                                    <div class="text-4xl font-bold text-teal-200 mb-2 drop-shadow-lg" x-text="stats.users">0</div>
                                    <div class="text-teal-50 font-medium">Pengguna Aktif</div>
                                </div>
                                <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                                    <div class="text-4xl font-bold text-teal-200 mb-2 drop-shadow-lg" x-text="stats.satisfaction">0%</div>
                                    <div class="text-teal-50 font-medium">Kepuasan</div>
                                </div>
                            </div>
                        </div>
                        <!-- Image -->
                        <div class="relative mt-12 lg:mt-0">
                            <div class="relative z-30">
                                <img src="{{ asset('images/logo.png') }}" alt="Digital Library Logo" class="w-full h-96 object-contain rounded-2xl">
                            </div>
                            <!-- Animated Background -->
                            <div class="absolute inset-0 bg-gradient-to-br from-teal-400/30 to-teal-600/30 rounded-2xl animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Dots -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-40">
            <template x-for="(slide, index) in 3" :key="index">
                <button @click="goToSlide(index)" 
                        :class="currentSlide === index ? 'bg-white shadow-lg' : 'bg-white/60 hover:bg-white/80'"
                        class="w-4 h-4 rounded-full transition-all duration-300 hover:scale-110"></button>
            </template>
        </div>

        <!-- Navigation Arrows -->
        <button @click="previousSlide" 
                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-teal-600 hover:bg-teal-700 text-white p-3 rounded-full transition-all duration-300 hover:scale-110 z-40 shadow-lg">
            <i class="fas fa-chevron-left text-lg"></i>
        </button>
        <button @click="nextSlide" 
                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-teal-600 hover:bg-teal-700 text-white p-3 rounded-full transition-all duration-300 hover:scale-110 z-40 shadow-lg">
            <i class="fas fa-chevron-right text-lg"></i>
        </button>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 animate-bounce z-30">
        <div class="w-6 h-10 border-2 border-white/70 rounded-full flex justify-center bg-white/20 backdrop-blur-sm">
            <div class="w-1 h-3 bg-white rounded-full mt-2 animate-pulse"></div>
        </div>
    </div>
</section>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('heroSlider', () => ({
        currentSlide: 0,
        autoPlay: true,
        autoPlayInterval: null,
        stats: {
            materials: 0,
            categories: 0,
            users: 0,
            satisfaction: 0
        },

        init() {
            this.startAutoPlay();
            this.animateStats();
        },

        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % 3;
        },

        previousSlide() {
            this.currentSlide = this.currentSlide === 0 ? 2 : this.currentSlide - 1;
        },

        goToSlide(index) {
            this.currentSlide = index;
        },

        startAutoPlay() {
            if (this.autoPlay) {
                this.autoPlayInterval = setInterval(() => {
                    this.nextSlide();
                }, 5000);
            }
        },

        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        },

        animateStats() {
            // Animate statistics with counting effect
            const targetStats = {
                materials: {{ $materials->count() ?? 150 }},
                categories: {{ $categories->count() ?? 12 }},
                users: 250,
                satisfaction: 98
            };

            Object.keys(targetStats).forEach(key => {
                const target = targetStats[key];
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        this.stats[key] = target;
                        clearInterval(timer);
                    } else {
                        this.stats[key] = Math.floor(current);
                    }
                }, 16);
            });
        }
    }));
});
</script>
