@props([
    'variant' => 'primary', 
    'type' => 'submit'
])

@php
    $baseClass = 'inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variants = [
        // UBAH: Primary jadi Hitam (Gray-900) ala Vercel
        'primary' => 'border-transparent bg-gray-900 text-white hover:bg-gray-800 focus:bg-gray-700 active:bg-gray-900 focus:ring-gray-900',
        
        // Secondary tetap Putih
        'secondary' => 'border-gray-300 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-indigo-500 disabled:opacity-25',
        
        // Danger tetap Merah
        'danger' => 'border-transparent bg-red-600 text-white hover:bg-red-500 active:bg-red-700 focus:ring-red-500',
    ];

    $classes = $baseClass . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>