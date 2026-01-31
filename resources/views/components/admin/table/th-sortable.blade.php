@props([
    'name' => null, // Nama kolom di DB (misal: 'email')
    'label' => '',  // Text yang muncul (misal: 'Email Address')
])

<th scope="col" {{ $attributes->merge(['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider']) }}>
    @if($name)
        <a href="{{ request()->fullUrlWithQuery(['sort' => $name, 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
           class="group inline-flex items-center hover:text-gray-700 transition-colors">
            
            {{ $label }}

            <span class="ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible">
                @if(request('sort') === $name)
                    @if(request('direction') === 'asc')
                        <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                    @else
                        <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    @endif
                @else
                    <svg class="h-4 w-4 opacity-0 group-hover:opacity-50 transition-opacity" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
                @endif
            </span>
        </a>
    @else
        {{ $label }}
    @endif
</th>