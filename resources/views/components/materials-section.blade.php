<div x-data="materialsPage()" class="min-h-0">
    <!-- Materials Container with Fixed Height -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Search and Filter Section -->
        <div class="bg-white rounded-t-xl shadow-sm border border-gray-200 border-b-0">
            <div class="px-4 py-4">
                <!-- Section Title -->
                <div class="mb-3">
                    <h2 class="text-xl font-semibold text-gray-900">Daftar Semua Materi</h2>
                </div>
                <!-- Search and Filters Row -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
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
                                class="block w-full pl-10 pr-4 py-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-colors duration-200 placeholder-gray-500"
                                autocomplete="off"
                            >
                        </div>
                    </div>

                    <!-- Compact Filters -->
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Category Filter -->
                        <div class="flex items-center space-x-2">
                            <label class="text-xs font-medium text-gray-600 whitespace-nowrap">Kategori:</label>
                            <select 
                                x-model="selectedCategory"
                                @change="filterMaterials()"
                                class="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm bg-white min-w-[140px]"
                            >
                                <option value="">Semua</option>
                                <template x-for="category in categories" :key="category.id">
                                    <option :value="category.id" x-text="category.display_name"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="flex items-center space-x-2">
                            <label class="text-xs font-medium text-gray-600 whitespace-nowrap">Tanggal:</label>
                            <input 
                                type="date" 
                                x-model="dateFrom"
                                @change="filterMaterials()"
                                class="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm bg-white"
                                placeholder="Dari"
                            >
                            <span class="text-gray-400">-</span>
                            <input 
                                type="date" 
                                x-model="dateTo"
                                @change="filterMaterials()"
                                class="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm bg-white"
                                placeholder="Sampai"
                            >
                        </div>

                        <!-- Sort Filter -->
                        <div class="flex items-center space-x-2">
                            <label class="text-xs font-medium text-gray-600 whitespace-nowrap">Urutkan:</label>
                            <select 
                                x-model="sortBy"
                                @change="filterMaterials()"
                                class="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm bg-white min-w-[120px]"
                            >
                                <option value="newest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                                <option value="title">Judul A-Z</option>
                                <option value="title_desc">Judul Z-A</option>
                                <option value="date_asc">Tanggal Awal</option>
                                <option value="date_desc">Tanggal Akhir</option>
                            </select>
                        </div>

                        <!-- View Toggle -->
                        <div class="flex items-center space-x-2">
                            <label class="text-xs font-medium text-gray-600 whitespace-nowrap">Tampilan:</label>
                            <div class="flex bg-gray-100 border border-gray-300 rounded-md p-1">
                                <button 
                                    @click="viewMode = 'grid'"
                                    :class="viewMode === 'grid' ? 'bg-teal-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                    class="px-3 py-1.5 rounded text-sm font-medium transition-all duration-200 flex items-center justify-center"
                                    title="Tampilan Grid"
                                >
                                    <i class="fas fa-th-large text-xs"></i>
                                </button>
                                <button 
                                    @click="viewMode = 'list'"
                                    :class="viewMode === 'list' ? 'bg-teal-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                    class="px-3 py-1.5 rounded text-sm font-medium transition-all duration-200 flex items-center justify-center"
                                    title="Tampilan List"
                                >
                                    <i class="fas fa-list text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Reset Button -->
                        <button 
                            @click="clearAllFilters()" 
                            x-show="hasActiveFilters()"
                            class="text-xs text-teal-600 hover:text-teal-700 font-medium flex items-center px-2 py-1 hover:bg-teal-50 rounded"
                        >
                            <i class="fas fa-times mr-1"></i>
                            Reset
                        </button>
                    </div>
                </div>

                <!-- Active Filters -->
                <div x-show="hasActiveFilters()" class="mt-3 flex flex-wrap gap-2">
                    <template x-for="filter in getActiveFilters()" :key="filter.key">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                            <span x-text="filter.label"></span>
                            <button @click="removeFilter(filter.key)" class="ml-1.5 hover:text-teal-600">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    </template>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div x-show="loading" class="text-center py-12 bg-white">
            <div class="text-teal-600 text-sm">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Memuat...
            </div>
        </div>

        <!-- Materials Container -->
        <div x-show="!loading" class="bg-white border-l border-r border-gray-200">
            <!-- Materials Grid/List with Fixed Height -->
            <div class="h-96 overflow-y-auto">
                <!-- Grid View -->
                <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
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

                <!-- List View - Compact -->
                <div x-show="viewMode === 'list'" class="space-y-1 p-4">
                    <template x-for="(material, index) in paginatedMaterials" :key="material.id">
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-200 p-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1 min-w-0">
                                    <!-- Status Icon with Color Variation -->
                                    <div 
                                        :class="getIconColorClass(index)"
                                        class="w-6 h-6 rounded-md flex items-center justify-center mr-2 flex-shrink-0"
                                    >
                                        <i :class="getIconClass(index)" class="text-xs"></i>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-0.5">
                                            <h3 class="text-sm font-semibold text-gray-900 truncate" x-text="material.title"></h3>
                                            <div class="flex items-center space-x-1 ml-2 flex-shrink-0">
                                                <span 
                                                    :class="getStatusClass(material)"
                                                    class="px-1.5 py-0.5 rounded-full text-xs font-medium"
                                                    x-text="getStatusLabel(material)"
                                                ></span>
                                                <span class="px-1.5 py-0.5 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                                                    Sumber: <span x-text="material.source"></span>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Context/Description -->
                                        <div x-show="material.context" class="mb-1">
                                            <p class="text-xs text-gray-600 line-clamp-2" x-text="stripHtml(material.context)"></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <!-- Right Status Tag -->
                                <div class="flex-shrink-0 ml-3" x-show="material.category">
                                    <span :class="getCategoryColorClass(index)" class="px-1.5 py-0.5 rounded-full text-xs font-medium">
                                        <span x-text="material.category?.display_name || material.category?.name"></span>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Bottom Row: Meta Info Left, Action Button Right -->
                            <div class="flex justify-between items-center mt-2">
                                <!-- Meta Info - Bottom Left -->
                                <div class="flex items-center space-x-3 text-xs text-gray-600">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt w-3 text-teal-600 mr-1"></i>
                                        <span>Pelaksanaan: <span x-text="formatDate(material.activity_date_start, material.activity_date_end, material.activity_date)"></span></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-user w-3 text-teal-600 mr-1"></i>
                                        <span>Uploader: <span x-text="material.uploader?.name || 'Administrator'"></span></span>
                                    </div>
                                </div>
                                
                                <!-- Action Link - Bottom Right -->
                                <button 
                                    @click="viewDetail(material.id)"
                                    class="text-teal-600 hover:text-teal-700 font-medium text-xs flex items-center"
                                >
                                    Lihat Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </button>
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
        </div>

        <!-- Integrated Pagination -->
        <div x-show="filteredMaterials.length > 0" class="bg-white rounded-b-xl shadow-sm border border-gray-200 border-t-0">
            <div class="px-4 py-3">
                <div class="flex items-center justify-between">
                    <!-- Mobile: Simple navigation -->
                    <div class="flex-1 flex justify-between sm:hidden">
                        <button 
                            @click="goToPage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            :class="currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:text-teal-600'"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-white border border-gray-300 rounded-md"
                        >
                            <i class="fas fa-chevron-left mr-1"></i>
                            Sebelumnya
                        </button>
                        
                        <span class="text-sm text-gray-700 self-center" x-text="`${currentPage}/${totalPages}`"></span>
                        
                        <button 
                            @click="goToPage(currentPage + 1)"
                            :disabled="currentPage === totalPages"
                            :class="currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:text-teal-600'"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-white border border-gray-300 rounded-md"
                        >
                            Selanjutnya
                            <i class="fas fa-chevron-right ml-1"></i>
                        </button>
                    </div>

                    <!-- Desktop: Compact pagination -->
                    <div class="hidden sm:flex sm:items-center sm:justify-between sm:w-full">
                        <!-- Results info -->
                        <div class="text-xs text-gray-600">
                            <span x-text="`${((currentPage - 1) * itemsPerPage) + 1}-${Math.min(currentPage * itemsPerPage, filteredMaterials.length)} dari ${filteredMaterials.length}`"></span>
                        </div>
                        
                        <!-- Pagination controls -->
                        <div class="flex items-center space-x-1">
                            <!-- Previous -->
                            <button 
                                @click="goToPage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                :class="currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'"
                                class="inline-flex items-center px-2 py-1.5 text-sm border border-gray-300 bg-white rounded-l-md"
                            >
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>

                            <!-- Page numbers -->
                            <template x-for="page in getVisiblePages()" :key="page">
                                <template x-if="page === '...'">
                                    <span class="inline-flex items-center px-2 py-1.5 text-sm border border-gray-300 bg-white text-gray-700">
                                        ...
                                    </span>
                                </template>
                                <template x-if="page !== '...'">
                                    <button 
                                        @click="goToPage(page)"
                                        :class="page === currentPage ? 'bg-teal-50 text-teal-600 border-teal-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                                        class="inline-flex items-center px-2 py-1.5 text-sm border font-medium"
                                        x-text="page"
                                    ></button>
                                </template>
                            </template>

                            <!-- Next -->
                            <button 
                                @click="goToPage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                :class="currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'"
                                class="inline-flex items-center px-2 py-1.5 text-sm border border-gray-300 bg-white rounded-r-md"
                            >
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        </div>

                        <!-- Page size selector -->
                        <div class="flex items-center space-x-1">
                            <label class="text-xs text-gray-600">Per halaman:</label>
                            <select 
                                x-model="itemsPerPage"
                                @change="changePageSize()"
                                class="text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-teal-500"
                            >
                                <option value="6">6</option>
                                <option value="12">12</option>
                                <option value="24">24</option>
                                <option value="48">48</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
