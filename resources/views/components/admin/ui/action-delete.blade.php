{{-- resources/views/components/admin/ui/action-delete.blade.php --}}
@props(['action'])

<div x-data="{ open: false }">
    <button @click="open = true" class="text-gray-400 hover:text-red-600 transition-colors">
        <x-admin.icon.trash />
    </button>

    {{-- Mini Modal / Dialog Konfirmasi --}}
    <template x-teleport="body">
        <div x-show="open" class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm" x-cloak>
            <div @click.away="open = false" class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-6 text-center">
                <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-admin.icon.trash class="w-8 h-8" />
                </div>
                <h3 class="text-lg font-bold text-gray-900">Confirm Delete</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to delete this data? This action cannot be undone.</p>
                
                <div class="flex gap-3 mt-6">
                    <button @click="open = false" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-md font-medium hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <form :action="'{{ $action }}'" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-md font-medium hover:bg-red-700 shadow-lg shadow-red-200 transition-all">
                            Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>