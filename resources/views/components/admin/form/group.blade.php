@props([
    'label' => null, 
    'name', 
    'required' => false,
    'inline' => false 
])

<div class="{{ $inline ? 'flex items-center gap-4' : 'mb-4' }}">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-500 {{ $inline ? 'w-1/4' : 'mb-1.5' }}">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="{{ $inline ? 'w-3/4' : '' }}">
        {{ $slot }}
        
        @error($name)
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>