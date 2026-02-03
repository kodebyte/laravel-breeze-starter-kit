<div x-data="{ tab: 'id' }" {{ $attributes->merge(['class' => 'block']) }}>
    
    {{-- TOOLBAR (Switcher Only) --}}
    <div class="flex items-center justify-end mb-4">
        
        {{-- CAPSULE SWITCHER --}}
        {{-- Style: White Background + Light Border --}}
        <div class="flex bg-white rounded-lg p-1 border border-gray-200 shadow-sm">
            
            {{-- Tab ID --}}
            <button type="button" @click.prevent="tab = 'id'" 
                :class="tab === 'id' ? 'bg-gray-100 text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                class="px-3 py-1.5 text-xs font-bold rounded-md transition-all flex items-center gap-2">
                <span>🇮🇩</span> <span class="hidden sm:inline">ID</span>
            </button>
            
            {{-- Tab EN --}}
            <button type="button" @click.prevent="tab = 'en'"
                :class="tab === 'en' ? 'bg-gray-100 text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                class="px-3 py-1.5 text-xs font-bold rounded-md transition-all flex items-center gap-2">
                <span>🇬🇧</span> <span class="hidden sm:inline">EN</span>
            </button>
        </div>

    </div>

    {{-- CONTENT WRAPPER --}}
    <div class="space-y-4">
        {{-- Content ID --}}
        <div x-show="tab === 'id'" class="space-y-4 transition-all duration-300">
            {{ $idContent }}
        </div>

        {{-- Content EN --}}
        <div x-show="tab === 'en'" x-cloak class="space-y-4 transition-all duration-300">
            {{ $enContent }}
        </div>
    </div>

</div>