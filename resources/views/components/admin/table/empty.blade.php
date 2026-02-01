@props([
    'colspan' => 1, 
    'createRoute' => null
])

@php
    // Cek apakah ada aktivitas pencarian
    $isSearching = request()->filled('search');

    // Tentukan konten berdasarkan kondisi
    $currentTitle = $isSearching ? 'No results found' : 'No data available';
    $currentMessage = $isSearching 
        ? "We couldn't find anything for '" . request('search') . "'. Try a different keyword."
        : "Your database is currently empty. Start by adding your first record.";
@endphp

<x-admin.table.tr>
    <x-admin.table.td :colspan="$colspan" class="py-16 text-center">
        <div class="flex flex-col items-center justify-center">
            
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                @if($isSearching)
                    <x-admin.icon.search class="w-10 h-10 text-gray-300" />
                @else
                    <x-admin.icon.empty-state class="text-gray-300" />
                @endif
            </div>
            
            <h3 class="text-sm font-bold text-gray-900 mb-1">{{ $currentTitle }}</h3>
            
            <p class="text-xs text-gray-400 max-w-[280px] mx-auto leading-relaxed">
                {{ $currentMessage }}
            </p>

            <div class="mt-6">
                @if($isSearching)
                    <a href="{{ url()->current() }}" class="inline-flex items-center px-4 py-2 text-xs font-bold text-gray-700 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-all">
                        <x-admin.icon.undo class="w-3 h-3 mr-2" />
                        Clear Search
                    </a>
                @else
                    @if($createRoute)
                        {{-- Tombol Add New otomatis muncul kalau data benar2 kosong --}}
                        <x-admin.ui.link-button href="{{ $createRoute ?? '#' }}" class="!normal-case !tracking-normal">
                            <x-admin.icon.plus class="w-3.5 h-3.5 mr-2" />
                            Add Your First Data
                    </x-admin.ui.link-button>
                    @endif 
                @endif
            </div>
        </div>
    </x-admin.table.td>
</x-admin.table.tr>