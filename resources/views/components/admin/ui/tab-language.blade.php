@props(['label' => null])

@php
    // Ambil default dari Config CMS, kalau gak ada fallback ke 'id'
    $default = config('cms.locale.default', 'id');
@endphp

<div x-data="{ language: '{{ $default }}' }" class="w-full">
    
    {{-- HEADER: TABS --}}
    <div class="flex items-center justify-between mb-4">
        @if($label)
            <label class="block text-sm font-semibold text-gray-700">{{ $label }}</label>
        @else
            <div></div> {{-- Spacer biar Flex justify-between tetap rapi --}}
        @endif

        {{-- TAB SWITCHER STYLE (White Container, Gray Active) --}}
        <div class="flex bg-white rounded-lg p-1 border border-gray-200 shadow-sm">
            
            {{-- Tab ID --}}
            <button type="button" @click="language = 'id'"
                :class="language === 'id' ? 'bg-gray-100 text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                class="px-3 py-1.5 text-xs font-bold rounded-md transition-all flex items-center gap-2">
                <span>🇮🇩</span> ID
            </button>
            
            {{-- Tab EN --}}
            <button type="button" @click="language = 'en'"
                :class="language === 'en' ? 'bg-gray-100 text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                class="px-3 py-1.5 text-xs font-bold rounded-md transition-all flex items-center gap-2">
                <span>🇺🇸</span> EN
            </button>
            
        </div>
    </div>

    {{-- CONTENT BODY --}}
    <div class="relative">
        {{-- Slot ID --}}
        <div x-show="language === 'id'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0">
            {{ $idContent ?? '' }}
        </div>

        {{-- Slot EN --}}
        <div x-show="language === 'en'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             style="display: none;">
            {{ $enContent ?? '' }}
        </div>
    </div>
</div>