@props([
    'label' => null, 
    'name', 
    'required' => false,
    'inline' => false 
])

@php
    // MAGIC: Convert "title[id]" or "seo[title][en]" -> "title.id" or "seo.title.en"
    // Biar bisa detect error bag Laravel
    $errorName = str_replace(['[', ']'], ['.', ''], $name);
    
    // Hapus titik di akhir kalau ada (kasus array multiple)
    $errorName = rtrim($errorName, '.');
@endphp

<div class="{{ $inline ? 'flex items-center gap-4' : 'mb-4' }}">
    @if($label)
        {{-- Note: label 'for' idealnya match ID input, tapi pake name is okay for now --}}
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-500 {{ $inline ? 'w-1/4' : 'mb-1.5' }}">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="{{ $inline ? 'w-3/4' : '' }}">
        {{ $slot }}
        
        {{-- Cek Error pake nama yang udah dikonversi --}}
        @error($errorName)
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>