@props([
    'type' => 'submit', 
    'color' => 'primary', // Default color
    'size'  => 'md'       // Default size (opsional)
])

@php
// 1. Definisikan Logika Warna
$colors = [
    'primary'   => 'bg-gray-900 hover:bg-black text-white shadow-sm border-transparent focus:ring-gray-900',
    'secondary' => 'bg-white hover:bg-gray-50 text-gray-700 border-gray-200 shadow-sm',
    'danger'    => 'bg-red-600 hover:bg-red-700 text-white shadow-sm border-transparent focus:ring-red-500', // <-- INI DIA KUNCINYA BRO!
    'success'   => 'bg-green-600 hover:bg-green-700 text-white shadow-sm border-transparent',
    'warning'   => 'bg-amber-500 hover:bg-amber-600 text-white shadow-sm border-transparent',
];

// 2. Definisikan Logika Ukuran (Opsional, buat jaga-jaga)
$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-5 py-2.5 text-base',
];

// 3. Gabungin class dasar + warna + ukuran
$baseClass = "inline-flex items-center justify-center border font-bold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed";
$colorClass = $colors[$color] ?? $colors['primary'];
$sizeClass  = $sizes[$size] ?? $sizes['md'];

$classes = "$baseClass $colorClass $sizeClass";
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
    {{ $slot }}
</button>