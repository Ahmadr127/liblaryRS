@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
<div class="content" x-data="{
    isOpen: false,
    loading: false,
    material: null,
    ...tableFilter({
        search: '{{ request('search') }}',
        category_id: '{{ request('category_id') }}',
        dateFrom: '{{ request('date_from') }}',
        dateTo: '{{ request('date_to') }}'
    }),
    
    async openModal(materialId) {
        this.isOpen = true;
        this.loading = true;
        this.material = null;
        
        try {
            console.log('Loading material details for ID:', materialId);
            const response = await fetch(`/materials/${materialId}/modal`);
            if (response.ok) {
                this.material = await response.json();
                console.log('Material data loaded:', this.material);
            } else {
                console.error('Failed to load material details:', response.status, response.statusText);
            }
        } catch (error) {
            console.error('Error loading material details:', error);
        } finally {
            this.loading = false;
        }
    },
    
    closeModal() {
        this.isOpen = false;
        this.material = null;
    }
}">
    <!-- Table Filter Component -->
    <x-table-filter 
        :show-category-filter="true"
        :categories="$categories->map(fn($c) => ['value' => $c->id, 'label' => $c->display_name])->toArray()"
    />

    <!-- Materials Table Component -->
    <x-materials-table 
        :materials="$materials"
        :show-actions="true"
        :show-uploader="true"
        :show-create-button="true"
        :create-route="route('materials.create')"
        create-button-text="Tambah Materi"
    />

    <!-- Responsive Pagination Component -->
    <x-responsive-pagination :paginator="$materials" />

    <!-- Modal Component -->
    <x-modal-detail-materials />
</div>

@endsection
