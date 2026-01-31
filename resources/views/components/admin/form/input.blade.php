@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm text-sm text-gray-900 bg-white placeholder-gray-400']) !!}>