@extends('layouts.landing')

@section('title', 'Semua Materi - Digital Library RS')

@section('content')
<div x-data="materialsPage()" class="min-h-screen bg-gray-50">
    <!-- Search and Filter Section -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative max-w-2xl">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input 
                        type="search" 
                        x-model="searchQuery"
                        @input="debounceSearch()"
                        placeholder="Cari materi..."
                        class="block w-full pl-10 pr-4 py-3 text-sm text-gray-900 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-colors duration-200 placeholder-gray-500"
                        autocomplete="off"
                    >
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Filter & Urutkan</h3>
                    <button 
                        @click="clearAllFilters()" 
                        x-show="hasActiveFilters()"
                        class="text-xs text-teal-600 hover:text-teal-700 font-medium flex items-center"
                    >
                        <i class="fas fa-times mr-1"></i>
                        Reset Filter
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    <!-- Category Filter -->
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wide">Kategori</label>
                        <select 
                            x-model="selectedCategory"
                            @change="filterMaterials()"
                            class="block w-full px-3 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm bg-white shadow-sm"
                        >
                            <option value="">Semua Kategori</option>
                            <template x-for="category in categories" :key="category.id">
                                <option :value="category.id" x-text="category.display_name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wide">Tanggal Mulai</label>
                        <input 
                            type="date" 
                            x-model="dateFrom"
                            @change="filterMaterials()"
                            class="block w-full px-3 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm bg-white shadow-sm"
                        >
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wide">Tanggal Akhir</label>
                        <input 
                            type="date" 
                            x-model="dateTo"
                            @change="filterMaterials()"
                            class="block w-full px-3 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm bg-white shadow-sm"
                        >
                    </div>

                    <!-- Sort Filter -->
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wide">Urutkan</label>
                        <select 
                            x-model="sortBy"
                            @change="filterMaterials()"
                            class="block w-full px-3 py-3.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm bg-white shadow-sm"
                        >
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="title">Judul A-Z</option>
                            <option value="title_desc">Judul Z-A</option>
                            <option value="date_asc">Tanggal Kegiatan (Awal)</option>
                            <option value="date_desc">Tanggal Kegiatan (Akhir)</option>
                        </select>
                    </div>

                    <!-- View Toggle -->
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wide">Tampilan</label>
                        <div class="flex bg-white border border-gray-300 rounded-lg p-1 shadow-sm">
                            <button 
                                @click="viewMode = 'grid'"
                                :class="viewMode === 'grid' ? 'bg-teal-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                class="flex-1 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center justify-center"
                                title="Tampilan Grid"
                            >
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button 
                                @click="viewMode = 'list'"
                                :class="viewMode === 'list' ? 'bg-teal-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                class="flex-1 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center justify-center"
                                title="Tampilan List"
                            >
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Filters -->
            <div x-show="hasActiveFilters()" class="mt-4 flex flex-wrap gap-2">
                <template x-for="filter in getActiveFilters()" :key="filter.key">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                        <span x-text="filter.label"></span>
                        <button @click="removeFilter(filter.key)" class="ml-2 hover:text-teal-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                </template>
                <button @click="clearAllFilters()" class="text-xs text-gray-500 hover:text-gray-700">
                    Hapus semua filter
                </button>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Results Info -->
        <div class="flex justify-between items-center mb-6">
            <div class="text-gray-600">
                <span x-text="filteredMaterials.length"></span> materi ditemukan
                <span x-show="searchQuery" class="ml-2">
                    untuk "<span x-text="searchQuery" class="font-medium text-gray-900"></span>"
                </span>
            </div>
            <div x-show="loading" class="text-teal-600">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Memuat...
            </div>
        </div>

        <!-- Materials Grid/List -->
        <div x-show="!loading">
            <!-- Grid View -->
            <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="material in paginatedMaterials" :key="material.id">
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-200">
                        <!-- Status Badge -->
                        <div class="p-4 pb-0">
                            <div class="flex justify-between items-start mb-3">
                                <span 
                                    :class="getStatusClass(material)"
                                    class="px-3 py-1 rounded-full text-xs font-medium"
                                    x-text="getStatusLabel(material)"
                                ></span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4 pt-0">
                            <div class="flex items-start mb-3">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-arrow-up text-teal-600 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1 line-clamp-2" x-text="material.title"></h3>
                                    <p class="text-sm text-gray-600 mb-2 line-clamp-2" x-text="material.source"></p>
                                </div>
                            </div>

                            <!-- Tags -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    Akan berlangsung
                                </span>
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full" x-text="'Sumber: ' + material.source"></span>
                            </div>

                            <!-- Meta Info -->
                            <div class="space-y-2 text-sm text-gray-600 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt w-4 text-teal-600 mr-2"></i>
                                    <span>Pelaksanaan: <span x-text="formatDate(material.activity_date_start, material.activity_date_end, material.activity_date)"></span></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-user w-4 text-teal-600 mr-2"></i>
                                    <span>Uploader: <span x-text="material.uploader?.name || 'Administrator'"></span></span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <button 
                                @click="viewDetail(material.id)"
                                class="w-full bg-teal-600 text-white py-2 px-4 rounded-lg hover:bg-teal-700 transition-colors font-medium text-sm"
                            >
                                <i class="fas fa-eye mr-2"></i>
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- List View -->
            <div x-show="viewMode === 'list'" class="space-y-4">
                <template x-for="material in paginatedMaterials" :key="material.id">
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-200 p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start flex-1">
                                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-arrow-up text-teal-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between mb-2">
                                        <h3 class="text-xl font-semibold text-gray-900 mb-1" x-text="material.title"></h3>
                                        <span 
                                            :class="getStatusClass(material)"
                                            class="px-3 py-1 rounded-full text-xs font-medium ml-4"
                                            x-text="getStatusLabel(material)"
                                        ></span>
                                    </div>
                                    <p class="text-gray-600 mb-3" x-text="material.source"></p>
                                    
                                    <!-- Tags -->
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                            Akan berlangsung
                                        </span>
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full" x-text="'Sumber: ' + material.source"></span>
                                    </div>

                                    <!-- Meta Info -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt w-4 text-teal-600 mr-2"></i>
                                            <span>Pelaksanaan: <span x-text="formatDate(material.activity_date_start, material.activity_date_end, material.activity_date)"></span></span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-user w-4 text-teal-600 mr-2"></i>
                                            <span>Uploader: <span x-text="material.uploader?.name || 'Administrator'"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center ml-4">
                                <button 
                                    @click="viewDetail(material.id)"
                                    class="bg-teal-600 text-white py-2 px-4 rounded-lg hover:bg-teal-700 transition-colors font-medium text-sm"
                                >
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredMaterials.length === 0" class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada materi ditemukan</h3>
                <p class="text-gray-600 mb-4">Coba ubah kata kunci pencarian atau filter yang digunakan</p>
                <button @click="clearAllFilters()" class="text-teal-600 hover:text-teal-700 font-medium">
                    Hapus semua filter
                </button>
            </div>
        </div>

        <!-- Pagination -->
        <div x-show="totalPages > 1" class="mt-8 flex justify-center">
            <nav class="flex items-center space-x-2">
                <button 
                    @click="goToPage(currentPage - 1)"
                    :disabled="currentPage === 1"
                    :class="currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:text-teal-600'"
                    class="px-3 py-2 rounded-md text-sm font-medium"
                >
                    <i class="fas fa-chevron-left"></i>
                </button>
                
                <template x-for="page in getVisiblePages()" :key="page">
                    <button 
                        @click="goToPage(page)"
                        :class="page === currentPage ? 'bg-teal-600 text-white' : 'text-gray-700 hover:text-teal-600 hover:bg-gray-50'"
                        class="px-3 py-2 rounded-md text-sm font-medium"
                        x-text="page"
                    ></button>
                </template>
                
                <button 
                    @click="goToPage(currentPage + 1)"
                    :disabled="currentPage === totalPages"
                    :class="currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:text-teal-600'"
                    class="px-3 py-2 rounded-md text-sm font-medium"
                >
                    <i class="fas fa-chevron-right"></i>
                </button>
            </nav>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('materialsPage', () => ({
        // Data
        materials: @json($materials ?? []),
        categories: @json($categories ?? []),
        filteredMaterials: [],
        
        // UI State
        loading: false,
        viewMode: 'list',
        
        // Filters
        searchQuery: '',
        selectedCategory: '',
        sortBy: 'newest',
        dateFrom: '',
        dateTo: '',
        
        // Pagination
        currentPage: 1,
        itemsPerPage: 12,
        
        // Computed
        get paginatedMaterials() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredMaterials.slice(start, end);
        },
        
        get totalPages() {
            return Math.ceil(this.filteredMaterials.length / this.itemsPerPage);
        },

        init() {
            this.filteredMaterials = [...this.materials];
            this.filterMaterials();
        },

        // Search with debounce
        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.filterMaterials();
            }, 300);
        },

        // Filter materials
        filterMaterials() {
            let filtered = [...this.materials];

            // Search filter
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(material => 
                    material.title.toLowerCase().includes(query) ||
                    material.source.toLowerCase().includes(query) ||
                    material.organizer?.toLowerCase().includes(query) ||
                    (material.context && material.context.toLowerCase().includes(query))
                );
            }

            // Category filter
            if (this.selectedCategory) {
                filtered = filtered.filter(material => 
                    material.category_id == this.selectedCategory
                );
            }

            // Date range filter
            if (this.dateFrom || this.dateTo) {
                filtered = filtered.filter(material => {
                    const materialDate = material.activity_date_start || material.activity_date;
                    if (!materialDate) return false;
                    
                    const date = new Date(materialDate);
                    const fromDate = this.dateFrom ? new Date(this.dateFrom) : null;
                    const toDate = this.dateTo ? new Date(this.dateTo) : null;
                    
                    if (fromDate && date < fromDate) return false;
                    if (toDate && date > toDate) return false;
                    
                    return true;
                });
            }

            // Sort
            filtered.sort((a, b) => {
                switch (this.sortBy) {
                    case 'oldest':
                        return new Date(a.created_at) - new Date(b.created_at);
                    case 'title':
                        return a.title.localeCompare(b.title);
                    case 'title_desc':
                        return b.title.localeCompare(a.title);
                    case 'date_asc':
                        const aDate = new Date(a.activity_date_start || a.activity_date || a.created_at);
                        const bDate = new Date(b.activity_date_start || b.activity_date || b.created_at);
                        return aDate - bDate;
                    case 'date_desc':
                        const aDateDesc = new Date(a.activity_date_start || a.activity_date || a.created_at);
                        const bDateDesc = new Date(b.activity_date_start || b.activity_date || b.created_at);
                        return bDateDesc - aDateDesc;
                    case 'newest':
                    default:
                        return new Date(b.created_at) - new Date(a.created_at);
                }
            });

            this.filteredMaterials = filtered;
            this.currentPage = 1;
        },

        // Helper methods
        hasActiveFilters() {
            return this.searchQuery || this.selectedCategory || this.sortBy !== 'newest' || this.dateFrom || this.dateTo;
        },

        getActiveFilters() {
            const filters = [];
            if (this.searchQuery) {
                filters.push({ key: 'search', label: `Pencarian: ${this.searchQuery}` });
            }
            if (this.selectedCategory) {
                const category = this.categories.find(c => c.id == this.selectedCategory);
                filters.push({ key: 'category', label: `Kategori: ${category?.display_name}` });
            }
            if (this.dateFrom) {
                filters.push({ key: 'dateFrom', label: `Dari: ${this.formatDateShort(this.dateFrom)}` });
            }
            if (this.dateTo) {
                filters.push({ key: 'dateTo', label: `Sampai: ${this.formatDateShort(this.dateTo)}` });
            }
            if (this.sortBy !== 'newest') {
                const sortLabels = {
                    oldest: 'Urutkan: Terlama',
                    title: 'Urutkan: Judul A-Z',
                    title_desc: 'Urutkan: Judul Z-A',
                    date_asc: 'Urutkan: Tanggal Kegiatan (Awal)',
                    date_desc: 'Urutkan: Tanggal Kegiatan (Akhir)'
                };
                filters.push({ key: 'sort', label: sortLabels[this.sortBy] });
            }
            return filters;
        },

        removeFilter(key) {
            switch (key) {
                case 'search':
                    this.searchQuery = '';
                    break;
                case 'category':
                    this.selectedCategory = '';
                    break;
                case 'dateFrom':
                    this.dateFrom = '';
                    break;
                case 'dateTo':
                    this.dateTo = '';
                    break;
                case 'sort':
                    this.sortBy = 'newest';
                    break;
            }
            this.filterMaterials();
        },

        clearAllFilters() {
            this.searchQuery = '';
            this.selectedCategory = '';
            this.sortBy = 'newest';
            this.dateFrom = '';
            this.dateTo = '';
            this.filterMaterials();
        },

        // Status helpers
        getStatusClass(material) {
            const today = new Date().toISOString().split('T')[0];
            const start = material.activity_date_start || material.activity_date;
            const end = material.activity_date_end || material.activity_date;

            if (!start) return 'bg-gray-100 text-gray-700';
            if (today < start) return 'bg-blue-100 text-blue-700';
            if (end && today > end) return 'bg-gray-100 text-gray-700';
            return 'bg-green-100 text-green-700';
        },

        getStatusLabel(material) {
            const today = new Date().toISOString().split('T')[0];
            const start = material.activity_date_start || material.activity_date;
            const end = material.activity_date_end || material.activity_date;

            if (!start) return 'Tidak terjadwal';
            if (today < start) return 'Akan berlangsung';
            if (end && today > end) return 'Sudah berlangsung';
            return 'Sedang berlangsung';
        },

        formatDate(start, end, singleDate) {
            // Check if we have a date range (start and end dates)
            if (start && end && start !== end) {
                const startFormatted = new Date(start).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                const endFormatted = new Date(end).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                return `${startFormatted} - ${endFormatted}`;
            }
            
            // Check if we have a single date (either from start or singleDate parameter)
            const dateToUse = start || singleDate;
            if (dateToUse) {
                return new Date(dateToUse).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }
            
            // No date available
            return 'Tidak terjadwal';
        },

        formatDateShort(dateString) {
            if (!dateString) return '';
            return new Date(dateString).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        },

        // Pagination
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },

        getVisiblePages() {
            const pages = [];
            const start = Math.max(1, this.currentPage - 2);
            const end = Math.min(this.totalPages, this.currentPage + 2);
            
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        },

        // Actions

        viewDetail(materialId) {
            window.location.href = `/materials/detail/${materialId}`;
        }
    }));
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
