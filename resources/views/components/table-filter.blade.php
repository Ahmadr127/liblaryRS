@props([
    'filters' => [],
    'searchPlaceholder' => 'Cari...',
    'showDateRange' => true,
    'showCategoryFilter' => false,
    'categories' => []
])

<div class="bg-white p-4 border-b border-gray-200 shadow-sm">
    <div class="flex flex-col xl:flex-row gap-3">
        <!-- Search Input -->
        <div class="flex-1 min-w-0">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input 
                    type="text" 
                    id="search" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="{{ $searchPlaceholder }}"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    x-model="filters.search"
                    @input.debounce.300ms="applyFilters()"
                >
            </div>
        </div>

        <!-- Category Filter -->
        @if($showCategoryFilter && count($categories) > 0)
        <div class="xl:w-40">
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select 
                id="category_id" 
                name="category_id"
                x-model="filters.category_id"
                @change="applyFilters()"
                class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category['value'] }}" {{ request('category_id') == $category['value'] ? 'selected' : '' }}>
                        {{ $category['label'] }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <!-- Date Range Filter -->
        @if($showDateRange)
        <div class="xl:w-36">
            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
            <input 
                type="date" 
                id="date_from" 
                name="date_from"
                value="{{ request('date_from') }}"
                x-model="filters.dateFrom"
                @change="applyFilters()"
                class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
        </div>

        <div class="xl:w-36">
            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
            <input 
                type="date" 
                id="date_to" 
                name="date_to"
                value="{{ request('date_to') }}"
                x-model="filters.dateTo"
                @change="applyFilters()"
                class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
        </div>

        <!-- Date Presets -->
        <div class="xl:w-40">
            <label class="block text-sm font-medium text-gray-700 mb-1">Preset Tanggal</label>
            <select 
                x-model="datePreset"
                @change="applyDatePreset()"
                class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
                <option value="">Pilih Preset</option>
                <option value="today">Hari Ini</option>
                <option value="yesterday">Kemarin</option>
                <option value="this_week">Minggu Ini</option>
                <option value="last_week">Minggu Lalu</option>
                <option value="this_month">Bulan Ini</option>
                <option value="last_month">Bulan Lalu</option>
                <option value="this_year">Tahun Ini</option>
                <option value="last_year">Tahun Lalu</option>
            </select>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex items-end gap-2 xl:flex-shrink-0">
            <button 
                type="button"
                @click="clearFilters()"
                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
            >
                <i class="fas fa-times mr-1"></i>
                Reset
            </button>
            
            <button 
                type="button"
                @click="applyFilters()"
                class="inline-flex items-center px-3 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fas fa-filter mr-1"></i>
                Filter
            </button>
        </div>
    </div>

    <!-- Active Filters Display -->
    <div x-show="hasActiveFilters()" class="mt-4 pt-4 border-t border-gray-200">
        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-sm font-medium text-gray-700">Filter Aktif:</span>
            <template x-for="(value, key) in getActiveFilters()" :key="key">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    <span x-text="getFilterLabel(key, value)"></span>
                    <button 
                        @click="removeFilter(key)"
                        class="ml-1.5 inline-flex items-center justify-center w-4 h-4 rounded-full text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </span>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('tableFilter', (initialFilters = {}) => ({
        filters: {
            search: initialFilters.search || '',
            category: initialFilters.category || '',
            dateFrom: initialFilters.dateFrom || '',
            dateTo: initialFilters.dateTo || '',
            ...initialFilters
        },
        datePreset: '',

        init() {
            // Initialize filters from URL params
            this.filters = {
                search: new URLSearchParams(window.location.search).get('search') || '',
                category_id: new URLSearchParams(window.location.search).get('category_id') || '',
                dateFrom: new URLSearchParams(window.location.search).get('date_from') || '',
                dateTo: new URLSearchParams(window.location.search).get('date_to') || '',
                ...initialFilters
            };
        },

        applyFilters() {
            const params = new URLSearchParams();
            
            if (this.filters.search) params.set('search', this.filters.search);
            if (this.filters.category_id) params.set('category_id', this.filters.category_id);
            if (this.filters.dateFrom) params.set('date_from', this.filters.dateFrom);
            if (this.filters.dateTo) params.set('date_to', this.filters.dateTo);
            
            // Preserve existing pagination and per_page
            const currentPage = new URLSearchParams(window.location.search).get('page');
            const currentPerPage = new URLSearchParams(window.location.search).get('per_page');
            if (currentPage) params.set('page', currentPage);
            if (currentPerPage) params.set('per_page', currentPerPage);
            
            const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.location.href = newUrl;
        },

        clearFilters() {
            this.filters = {
                search: '',
                category_id: '',
                dateFrom: '',
                dateTo: '',
                ...initialFilters
            };
            
            // Remove all filter params from URL but preserve per_page
            const currentPerPage = new URLSearchParams(window.location.search).get('per_page');
            let newUrl = window.location.pathname;
            if (currentPerPage) {
                newUrl += '?per_page=' + currentPerPage;
            }
            window.location.href = newUrl;
        },

        removeFilter(key) {
            this.filters[key] = '';
            this.applyFilters();
        },

        hasActiveFilters() {
            return Object.values(this.filters).some(value => value !== '' && value !== null);
        },

        getActiveFilters() {
            const active = {};
            Object.entries(this.filters).forEach(([key, value]) => {
                if (value !== '' && value !== null) {
                    active[key] = value;
                }
            });
            return active;
        },

        getFilterLabel(key, value) {
            const labels = {
                search: `Pencarian: "${value}"`,
                category_id: `Kategori: ${this.getCategoryLabel(value)}`,
                dateFrom: `Dari: ${this.formatDate(value)}`,
                dateTo: `Sampai: ${this.formatDate(value)}`
            };
            return labels[key] || `${key}: ${value}`;
        },

        getCategoryLabel(value) {
            const categories = @json($categories);
            const category = categories.find(cat => String(cat.value) === String(value));
            return category ? category.label : value;
        },

        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        },

        applyDatePreset() {
            if (!this.datePreset) return;
            
            const today = new Date();
            let dateFrom = '';
            let dateTo = '';
            
            switch (this.datePreset) {
                case 'today':
                    dateFrom = dateTo = this.formatDateForInput(today);
                    break;
                case 'yesterday':
                    const yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1);
                    dateFrom = dateTo = this.formatDateForInput(yesterday);
                    break;
                case 'this_week':
                    const startOfWeek = new Date(today);
                    startOfWeek.setDate(today.getDate() - today.getDay());
                    dateFrom = this.formatDateForInput(startOfWeek);
                    dateTo = this.formatDateForInput(today);
                    break;
                case 'last_week':
                    const lastWeekStart = new Date(today);
                    lastWeekStart.setDate(today.getDate() - today.getDay() - 7);
                    const lastWeekEnd = new Date(today);
                    lastWeekEnd.setDate(today.getDate() - today.getDay() - 1);
                    dateFrom = this.formatDateForInput(lastWeekStart);
                    dateTo = this.formatDateForInput(lastWeekEnd);
                    break;
                case 'this_month':
                    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                    dateFrom = this.formatDateForInput(startOfMonth);
                    dateTo = this.formatDateForInput(today);
                    break;
                case 'last_month':
                    const lastMonthStart = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
                    dateFrom = this.formatDateForInput(lastMonthStart);
                    dateTo = this.formatDateForInput(lastMonthEnd);
                    break;
                case 'this_year':
                    const startOfYear = new Date(today.getFullYear(), 0, 1);
                    dateFrom = this.formatDateForInput(startOfYear);
                    dateTo = this.formatDateForInput(today);
                    break;
                case 'last_year':
                    const lastYearStart = new Date(today.getFullYear() - 1, 0, 1);
                    const lastYearEnd = new Date(today.getFullYear() - 1, 11, 31);
                    dateFrom = this.formatDateForInput(lastYearStart);
                    dateTo = this.formatDateForInput(lastYearEnd);
                    break;
            }
            
            this.filters.dateFrom = dateFrom;
            this.filters.dateTo = dateTo;
            this.applyFilters();
        },

        formatDateForInput(date) {
            return date.toISOString().split('T')[0];
        }
    }));
});
</script>
