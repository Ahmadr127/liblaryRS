<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Berita Terbaru</h2>
            <a href="{{ route('public.news.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">Lihat semua</a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse(($latestNews ?? []) as $item)
            <a href="{{ route('public.news.show', $item) }}" class="block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                @php $img = $item->image_url ?? asset('images/news.png'); @endphp
                <div class="w-full h-28 bg-gray-50 flex items-center justify-center overflow-hidden">
                    <img src="{{ $img }}" alt="{{ $item->title }}" class="max-h-28 w-auto object-contain">
                </div>
                <div class="p-3">
                    <div class="text-[11px] text-gray-500 mb-1">
                        {{ $item->published_at?->format('d M Y') }}
                        @if($item->category)
                        • {{ $item->category->display_name }}
                        @endif
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-1">{{ $item->title }}</h3>
                    <p class="text-xs text-gray-600 line-clamp-3">{{ $item->excerpt }}</p>
                </div>
            </a>
            @empty
            <div class="col-span-full text-sm text-gray-600">Belum ada berita.</div>
            @endforelse
        </div>
    </div>
</div>


