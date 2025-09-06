<!-- Calendar & Schedule Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-left mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Jadwal Kegiatan</h2>
            <p class="text-base md:text-lg text-gray-600">Pilih tanggal untuk melihat jadwal kegiatan yang tersedia</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Calendar -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-5 lg:basis-[35%] min-h-[520px]">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-900">Kalender Kegiatan</h3>
                    <div class="flex items-center space-x-2">
                        <button @click="previousMonth()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-chevron-left text-gray-600"></i>
                        </button>
                        <button @click="nextMonth()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-chevron-right text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <div class="text-left mb-3">
                    <h4 class="text-base md:text-lg font-semibold text-gray-900" x-text="currentMonthYear"></h4>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-1 mb-3">
                    <!-- Days of week -->
                    <div class="text-center py-2 text-sm font-medium text-teal-600">SEN</div>
                    <div class="text-center py-2 text-sm font-medium text-teal-600">SEL</div>
                    <div class="text-center py-2 text-sm font-medium text-teal-600">RAB</div>
                    <div class="text-center py-2 text-sm font-medium text-teal-600">KAM</div>
                    <div class="text-center py-2 text-sm font-medium text-teal-600">JUM</div>
                    <div class="text-center py-2 text-sm font-medium text-teal-600">SAB</div>
                    <div class="text-center py-2 text-sm font-medium text-teal-600">MIN</div>
                </div>

                <div class="grid grid-cols-7 gap-1">
                    <template x-for="day in calendarDays" :key="day.date">
                        <button 
                            @click="selectDate(day.date)"
                            :class="{
                                'bg-teal-600 text-white': day.isSelected,
                                'bg-gray-100 text-gray-400': !day.isCurrentMonth,
                                'bg-white text-gray-900 hover:bg-teal-50': day.isCurrentMonth && !day.isSelected,
                                'bg-orange-100 text-orange-800': day.hasEvents && !day.isSelected
                            }"
                            class="aspect-square flex items-center justify-center text-sm rounded-lg transition-colors relative"
                            :disabled="!day.isCurrentMonth"
                        >
                            <span x-text="day.day"></span>
                            <div x-show="day.hasEvents && !day.isSelected" class="absolute bottom-1 w-1 h-1 bg-orange-500 rounded-full"></div>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Schedule List -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 lg:basis-[65%] min-h-[520px]">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-900">Daftar Kegiatan</h3>
                    <span class="text-sm text-gray-500" x-text="selectedDateText"></span>
                </div>

                <div class="space-y-4 overflow-y-auto max-h-[420px]" id="schedule-list">
                    <template x-for="material in filteredMaterials" :key="material.id">
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-arrow-up text-blue-600 text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-sm leading-tight" x-text="material.title"></h4>
                                        <p class="text-xs text-gray-600 mt-1" x-text="material.organizer"></p>
                                    </div>
                                </div>
                                <div class="flex flex-col space-y-1">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-teal-100 text-teal-800" x-text="material.category_label"></span>
                                </div>
                            </div>

                            <!-- Status Tags -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full" :class="statusFor(material).cls" x-text="statusFor(material).label"></span>
                                <template x-if="material.source">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800" x-text="'Sumber: ' + material.source"></span>
                                </template>
                            </div>

                            <!-- Date Information -->
                            <div class="space-y-2">
                                <div class="flex items-center text-xs text-gray-600">
                                    <i class="fas fa-calendar mr-2 text-teal-600"></i>
                                    <span x-text="'Pelaksanaan: ' + (material.activity_date_range || material.display_activity_date || 'Tidak ada tanggal')"></span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600">
                                    <i class="fas fa-user mr-2 text-teal-600"></i>
                                    <span x-text="'Uploader: ' + (material.uploader?.name || 'Tidak diketahui')"></span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <a :href="'{{ url('/materials/detail') }}/' + material.id" class="inline-flex items-center text-sm text-teal-600 hover:text-teal-700 font-medium">
                                    Lihat Detail
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </template>

                    <!-- Empty State -->
                    <div x-show="filteredMaterials.length === 0" class="text-center py-8">
                        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Tidak ada kegiatan</h4>
                        <p class="text-gray-600">Pilih tanggal lain untuk melihat jadwal kegiatan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
