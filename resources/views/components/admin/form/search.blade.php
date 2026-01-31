@props([
    'placeholder' => 'Search...',
    'action' => null,
])

<form method="GET" action="{{ $action ?? url()->current() }}" class="w-full sm:w-72 relative">
    
    {{-- Keep Existing Params --}}
    @foreach(request()->query() as $key => $value)
        @if(!in_array($key, ['search', 'cursor']) && is_string($value))
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach

    <div class="relative group">
        {{-- Icon Search (Kiri) --}}
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <x-admin.icon.search class="h-4 w-4 text-gray-400 group-focus-within:text-primary transition-colors" />
        </div>
        
        {{-- Input --}}
        {{-- Tambahin pr-9 biar teks gak nabrak tombol X --}}
        <input type="text" 
               name="search" 
               value="{{ request('search') }}" 
               class="block w-full pl-9 pr-9 sm:text-sm border-gray-200 rounded-md focus:ring-primary focus:border-primary placeholder-gray-400 bg-gray-50 focus:bg-white transition-all duration-200" 
               placeholder="{{ $placeholder }}">

        {{-- TOMBOL RESET (X) --}}
        {{-- Muncul cuma kalau lagi ada search --}}
        @if(request('search'))
            <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                {{-- Link ke URL saat ini tapi search-nya dibikin null --}}
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" 
                   class="p-1 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-all"
                   title="Clear Search">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</form>