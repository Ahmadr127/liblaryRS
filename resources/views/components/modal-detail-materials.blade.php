<!-- Modal -->
<div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="closeModal()" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal panel -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Materi</h3>
                    <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div x-show="loading" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i>
                    <p class="mt-2 text-gray-500">Memuat detail materi...</p>
                </div>
                
                <div x-show="!loading && material" class="space-y-6">
                    <!-- Kategori -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Kategori:</span>
                        <span x-text="material?.category_label || ''" class="inline-flex px-3 py-1 text-sm font-semibold rounded-full"
                              :class="{
                                  'bg-blue-100 text-blue-800': material?.category === 'medis',
                                  'bg-green-100 text-green-800': material?.category === 'keperawatan',
                                  'bg-gray-100 text-gray-800': material?.category === 'umum'
                              }">
                        </span>
                    </div>

                    <!-- Judul -->
                    <div class="flex items-start space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Judul:</span>
                        <div class="flex-1">
                            <h2 x-text="material?.title || ''" class="text-lg font-semibold text-gray-900"></h2>
                        </div>
                    </div>

                    <!-- Penyelenggara -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Penyelenggara:</span>
                        <span x-text="material?.organizer || ''" class="text-gray-900"></span>
                    </div>

                    <!-- Sumber -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Sumber:</span>
                        <span x-text="material?.source || ''" class="text-gray-900"></span>
                    </div>

                    <!-- Konteks -->
                    <div x-show="material?.context" class="flex items-start space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Konteks:</span>
                        <div class="flex-1">
                            <div x-html="material?.context || ''" class="text-gray-900 prose max-w-none"></div>
                        </div>
                    </div>

                    <!-- Tanggal Kegiatan -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Tanggal:</span>
                        <span x-text="material?.activity_date_range || material?.activity_date_formatted || ''" class="text-gray-900"></span>
                    </div>

                    <!-- Uploader -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Uploader:</span>
                        <span x-text="material?.uploader?.name || ''" class="text-gray-900"></span>
                    </div>

                    <!-- Files -->
                    <div class="flex items-start space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Files:</span>
                        <div class="flex-1">
                            <div x-show="material?.files && material.files.length > 0" class="space-y-3">
                                <template x-for="file in material?.files || []" :key="file.id">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                            <div>
                                                <div x-text="file.original_name" class="text-sm font-medium text-gray-900"></div>
                                                <div x-text="file.formatted_size" class="text-xs text-gray-500"></div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a :href="'/materials/files/' + file.id + '/preview'" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm mr-2">
                                                <i class="fas fa-eye mr-1"></i>
                                                Preview
                                            </a>
                                            <a :href="'/materials/files/' + file.id + '/download'" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                <i class="fas fa-download mr-1"></i>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div x-show="!material?.files || material.files.length === 0" class="text-gray-500">
                                Tidak ada file
                            </div>
                        </div>
                    </div>

                    <!-- Created/Updated -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Dibuat:</span>
                        <span x-text="material?.created_at_formatted || ''" class="text-gray-900"></span>
                    </div>

                    <div x-show="material?.updated_at && material.updated_at !== material.created_at" class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-500 w-24">Diupdate:</span>
                        <span x-text="material?.updated_at_formatted || ''" class="text-gray-900"></span>
                    </div>
                </div>
                
                <div x-show="!loading && !material" class="text-center py-8">
                    <p class="text-gray-500">Gagal memuat detail materi</p>
                </div>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button @click="closeModal()" type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
