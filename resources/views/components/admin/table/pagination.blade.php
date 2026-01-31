@props(['data'])

<div class="flex items-center gap-2">
    {{-- PREVIOUS BUTTON --}}
    @if ($data->onFirstPage())
        <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-300 bg-white border border-gray-100 rounded-md cursor-not-allowed shadow-sm">
            Prev
        </span>
    @else
        <a href="{{ $data->previousPageUrl() }}" 
           class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-md shadow-sm hover:bg-gray-50 hover:text-primary transition-all duration-200">
            Prev
        </a>
    @endif

    {{-- NEXT BUTTON --}}
    @if ($data->hasMorePages())
        <a href="{{ $data->nextPageUrl() }}" 
           class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-md shadow-sm hover:bg-gray-50 hover:text-primary transition-all duration-200">
            Next
        </a>
    @else
        <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-300 bg-white border border-gray-100 rounded-md cursor-not-allowed shadow-sm">
            Next
        </span>
    @endif
</div>