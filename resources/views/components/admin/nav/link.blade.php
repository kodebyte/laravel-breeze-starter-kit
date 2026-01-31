@props(['active' => false])

@php
// Kelas untuk menu yang SEDANG AKTIF (Background gelap/terang dikit)
$activeClasses = 'bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md';

// Kelas untuk menu yang TIDAK AKTIF (Text gray, pas hover jadi putih)
$inactiveClasses = 'text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md';

$classes = $active ? $activeClasses : $inactiveClasses;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }} 
</a>