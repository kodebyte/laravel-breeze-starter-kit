@props(['data'])

<div class="px-6 py-4 border-t border-gray-100 bg-white rounded-b-lg flex flex-col sm:flex-row items-center justify-between gap-4">
    
    <div class="w-full sm:w-auto flex justify-center sm:justify-start">
        <x-admin.table.per-page />
    </div>

    <div class="w-full sm:w-auto flex items-center justify-center sm:justify-end gap-4">
        
        <div class="text-xs text-gray-500">
            Showing <span class="font-bold text-gray-900">{{ count($data) }}</span> records
        </div>

        <div class="h-4 w-px bg-gray-200 hidden sm:block"></div>

        <x-admin.table.pagination :data="$data" />
    </div>

</div>