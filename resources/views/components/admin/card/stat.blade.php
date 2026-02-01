@props([
    'label', 
    'value', 
    'icon', 
    'color' => 'primary', 
    'href' => '#'
])

@php
    // Mapping warna biar codingan di view utama tetep pendek
    $colors = [
        'primary' => 'bg-blue-50 text-blue-600 group-hover:border-blue-200 group-hover:ring-blue-50',
        'info'    => 'bg-cyan-50 text-cyan-600 group-hover:border-cyan-200 group-hover:ring-cyan-50',
        'purple'  => 'bg-purple-50 text-purple-600 group-hover:border-purple-200 group-hover:ring-purple-50',
        'warning' => 'bg-orange-50 text-orange-600 group-hover:border-orange-200 group-hover:ring-orange-50',
        'success' => 'bg-green-50 text-green-600 group-hover:border-green-200 group-hover:ring-green-50',
    ];
    
    $theme = $colors[$color] ?? $colors['primary'];
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'group bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 flex items-start justify-between relative overflow-hidden ' . str_replace('bg-', 'hover:border-', explode(' ', $theme)[0])]) }}>
    
    {{-- Content Kiri --}}
    <div>
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">{{ $label }}</p>
        <h3 class="text-2xl font-bold text-gray-900 group-hover:text-primary transition-colors">
            {{ $value }}
        </h3>
        
        {{-- Slot buat Trend (Misal: +5% arrow) --}}
        @if(isset($trend))
            <div class="mt-2">
                {{ $trend }}
            </div>
        @endif
    </div>

    {{-- Icon Kanan (Dengan Background Warna) --}}
    <div class="p-3 rounded-xl {{ explode(' ', $theme)[0] }} {{ explode(' ', $theme)[1] }} transition-transform group-hover:scale-110">
        {{ $icon }}
    </div>

    {{-- Dekorasi Circle di Background (Opsional, biar manis) --}}
    <div class="absolute -bottom-4 -right-4 w-24 h-24 rounded-full opacity-5 pointer-events-none {{ explode(' ', $theme)[0] }}"></div>
</a>