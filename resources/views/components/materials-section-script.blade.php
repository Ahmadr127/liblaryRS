<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('materialsPage', () => ({
        // Data
        materials: @json($formattedMaterials ?? []),
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
        itemsPerPage: 6,
        
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
            const totalPages = this.totalPages;
            const currentPage = this.currentPage;
            
            if (totalPages <= 7) {
                // Show all pages if 7 or fewer
                for (let i = 1; i <= totalPages; i++) {
                    pages.push(i);
                }
            } else {
                // Always show first page
                pages.push(1);
                
                if (currentPage <= 4) {
                    // Near the beginning
                    for (let i = 2; i <= 5; i++) {
                        pages.push(i);
                    }
                    pages.push('...');
                    pages.push(totalPages);
                } else if (currentPage >= totalPages - 3) {
                    // Near the end
                    pages.push('...');
                    for (let i = totalPages - 4; i <= totalPages; i++) {
                        pages.push(i);
                    }
                } else {
                    // In the middle
                    pages.push('...');
                    for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                        pages.push(i);
                    }
                    pages.push('...');
                    pages.push(totalPages);
                }
            }
            
            return pages;
        },

        changePageSize() {
            this.currentPage = 1; // Reset to first page when changing page size
        },

        // Color variation methods for list view
        getIconColorClass(index) {
            const colors = [
                'bg-teal-100', 'bg-blue-100', 'bg-purple-100', 'bg-pink-100', 
                'bg-indigo-100', 'bg-cyan-100', 'bg-emerald-100', 'bg-amber-100'
            ];
            return colors[index % colors.length];
        },

        getIconClass(index) {
            const icons = [
                'fas fa-arrow-up text-teal-600', 'fas fa-star text-blue-600', 
                'fas fa-heart text-purple-600', 'fas fa-bookmark text-pink-600',
                'fas fa-flag text-indigo-600', 'fas fa-gem text-cyan-600',
                'fas fa-leaf text-emerald-600', 'fas fa-sun text-amber-600'
            ];
            return icons[index % icons.length];
        },

        getCategoryColorClass(index) {
            const colors = [
                'bg-green-100 text-green-800', 'bg-blue-100 text-blue-800',
                'bg-purple-100 text-purple-800', 'bg-pink-100 text-pink-800',
                'bg-indigo-100 text-indigo-800', 'bg-cyan-100 text-cyan-800',
                'bg-emerald-100 text-emerald-800', 'bg-amber-100 text-amber-800'
            ];
            return colors[index % colors.length];
        },

        // Strip HTML tags from text
        stripHtml(html) {
            if (!html) return '';
            const tmp = document.createElement('div');
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || '';
        },

        // Actions
        viewDetail(materialId) {
            window.location.href = `/materials/detail/${materialId}`;
        }
    }));
});
</script>
