@props(['name'])

<div {{ $attributes->merge(['class' => 'flex-shrink-0 h-9 w-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm border border-primary/10']) }}>
    {{ substr($name, 0, 1) }}
</div>