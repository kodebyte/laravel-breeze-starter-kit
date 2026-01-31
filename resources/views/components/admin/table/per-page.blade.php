<div class="flex items-center gap-2">
    <span class="text-xs font-medium text-gray-500">Rows:</span>
    
    <form method="GET">
        {{-- Keep Params Logic (Sama kayak sebelumnya) --}}
        @foreach(request()->query() as $key => $value)
            @if($key !== 'per_page' && is_string($value)) 
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        <select name="per_page" 
                onchange="this.form.submit()" 
                class="text-xs font-medium text-gray-700 border-gray-200 rounded-md focus:border-primary focus:ring-1 focus:ring-primary/50 py-1 pl-2 pr-6 bg-white shadow-sm cursor-pointer hover:border-gray-300 transition-colors">
            @foreach([20, 40, 60, 80, 100] as $size)
                <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                    {{ $size }}
                </option>
            @endforeach
        </select>
    </form>
</div>