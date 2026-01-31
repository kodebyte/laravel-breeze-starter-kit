<div {!! $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100']) !!}>
    <div class="p-6 text-gray-900">
        {{ $slot }}
    </div>
</div>