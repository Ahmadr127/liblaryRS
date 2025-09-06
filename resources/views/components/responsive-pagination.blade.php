@props(['paginator'])

@if($paginator->hasPages())
<div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
    <div class="flex items-center justify-between">
        <!-- Mobile: Show current page info -->
        <div class="flex-1 flex justify-between sm:hidden">
            <div class="flex items-center space-x-2">
                @if($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                        <i class="fas fa-chevron-left mr-2"></i>
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <i class="fas fa-chevron-left mr-2"></i>
                        Sebelumnya
                    </a>
                @endif
                
                @if($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        Selanjutnya
                        <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                        Selanjutnya
                        <i class="fas fa-chevron-right ml-2"></i>
                    </span>
                @endif
            </div>
            
            <!-- Page info -->
            <div class="flex items-center text-sm text-gray-700">
                <span>
                    Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
                </span>
            </div>
        </div>

        <!-- Desktop: Full pagination -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Menampilkan
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    sampai
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    hasil
                </p>
            </div>
            
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <!-- Previous Page Link -->
                    @if($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-default">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left h-5 w-5"></i>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left h-5 w-5"></i>
                        </a>
                    @endif

                    <!-- Pagination Elements -->
                    @php
                        $currentPage = $paginator->currentPage();
                        $lastPage = $paginator->lastPage();
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($lastPage, $currentPage + 2);
                    @endphp
                    
                    @if($startPage > 1)
                        <a href="{{ $paginator->url(1) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            1
                        </a>
                        @if($startPage > 2)
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500">
                                ...
                            </span>
                        @endif
                    @endif
                    
                    @for($page = $startPage; $page <= $endPage; $page++)
                        @if($page == $currentPage)
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-indigo-50 text-sm font-medium text-indigo-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $paginator->url($page) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                {{ $page }}
                            </a>
                        @endif
                    @endfor
                    
                    @if($endPage < $lastPage)
                        @if($endPage < $lastPage - 1)
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500">
                                ...
                            </span>
                        @endif
                        <a href="{{ $paginator->url($lastPage) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            {{ $lastPage }}
                        </a>
                    @endif

                    <!-- Next Page Link -->
                    @if($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right h-5 w-5"></i>
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-default">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right h-5 w-5"></i>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Page size selector (Desktop only) -->
    <div class="hidden lg:flex lg:items-center lg:justify-end mt-4 pt-4 border-t border-gray-200">
        <div class="flex items-center space-x-2">
            <label for="per-page" class="text-sm font-medium text-gray-700">Tampilkan per halaman:</label>
            <select 
                id="per-page" 
                class="block w-20 px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                onchange="changePageSize(this.value)"
            >
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>
    </div>
</div>

<script>
function changePageSize(size) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', size);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}
</script>
@endif
