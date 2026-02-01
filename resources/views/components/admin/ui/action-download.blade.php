@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center p-1.5 bg-white border border-gray-200 rounded-lg text-gray-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm']) }} title="Download Backup">
    {{-- Icon Download --}}
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
    </svg>
</a>