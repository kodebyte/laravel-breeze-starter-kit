@props(['href', 'active' => false, 'title'])

<a href="{{ $href }}" 
   {{ $attributes->merge(['class' => 'flex items-center px-3 py-2 text-sm font-medium rounded-md group transition-all duration-200 ' . 
        ($active 
            ? 'bg-gray-100 text-gray-900' 
            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
        )
   ]) }}>
    
    {{-- Slot buat Icon --}}
    {{-- Kita inject class text color dinamis ke icon biar ikut active state --}}
    <div class="{{ $active ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-500' }}">
        {{ $slot }}
    </div>
    
    <span class="ml-3">
        {{ $title }}
    </span>
</a>