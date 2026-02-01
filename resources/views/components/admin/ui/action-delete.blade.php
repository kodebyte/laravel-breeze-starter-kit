@props(['action'])

<div x-data="{ open: false }" class="inline-block">
    {{-- Trigger Button: Updated Style (Bordered & Consistent) --}}
    <button 
        @click="open = true" 
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center p-1.5 bg-white border border-gray-200 rounded-lg text-gray-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all shadow-sm']) }} 
        title="Delete">
        <x-admin.icon.trash class="w-4 h-4" />
    </button>

    {{-- Modal Konfirmasi (Alpine.js) --}}
    <template x-teleport="body">
        <div 
            x-show="open" 
            class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm" 
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div 
                @click.away="open = false" 
                class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-6 text-center transform transition-all"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-admin.icon.trash class="w-8 h-8" />
                </div>
                
                <h3 class="text-lg font-bold text-gray-900">Confirm Delete</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to delete this data? This action cannot be undone.</p>
                
                <div class="flex gap-3 mt-6">
                    <button @click="open = false" type="button" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-bold text-sm hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    
                    <form action="{{ $action }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-bold text-sm hover:bg-red-700 shadow-lg shadow-red-200 transition-all">
                            Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>