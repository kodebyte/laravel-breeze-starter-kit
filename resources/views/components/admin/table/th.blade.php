@props(['label'])

<th scope="col" {{ $attributes->merge(['class' => 'px-6 py-4 text-left text-[11px] font-bold text-gray-400 uppercase tracking-widest']) }}>
    {{ $label ?? $slot }}
</th>