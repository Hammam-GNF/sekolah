<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Orang Tua') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    <div style="text-align: right; margin-bottom: 10px;">
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="bi bi-database-add"></i> Tambah
                        </button>
                    </div>
                    @include('ortu.partials.table')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')        
        @include('ortu.partials.scripts')
        @include('ortu.modals.create')
        @include('ortu.modals.edit')
    @endpush

</x-app-layout>
