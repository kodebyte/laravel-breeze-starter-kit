@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center p-1.5 bg-white border border-gray-200 rounded-lg text-gray-400 hover:text-purple-600 hover:border-purple-200 hover:bg-purple-50 transition-all shadow-sm']) }} title="View Details">
    <x-admin.icon.eye class="w-4 h-4" />
</a>