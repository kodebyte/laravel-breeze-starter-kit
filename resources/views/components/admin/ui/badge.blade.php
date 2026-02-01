@props([
    'color' => 'gray',
    'label' => '',
])

@php
    $colors = [
        'gray'      => 'bg-gray-100 text-gray-800 border-gray-200',
        'red'       => 'bg-red-50 text-red-700 border-red-100',
        'yellow'    => 'bg-yellow-50 text-yellow-700 border-yellow-100',
        'green'     => 'bg-green-50 text-green-700 border-green-100',
        'blue'      => 'bg-blue-50 text-blue-700 border-blue-100',
        'indigo'    => 'bg-indigo-50 text-indigo-700 border-indigo-100',
        'primary'   => 'bg-primary/10 text-primary border-primary/20',
        'success'   => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'danger'    => 'bg-rose-50 text-rose-700 border-rose-100',
    ];

    // Gunakan $colorClass untuk menggantikan $classes yang typo tadi
    $colorClass = $colors[$color] ?? $colors['gray'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {$colorClass} uppercase tracking-wider"]) }}>
    {{ $label ?: $slot }}
</span>