<li data-id="{{ $item->id }}" class="relative">
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-3 flex items-center justify-between group hover:border-primary/50 transition-colors {{ !$item->is_active ? 'opacity-60 bg-gray-50' : '' }}">
        
        {{-- KIRI: DRAG HANDLE & INFO --}}
        <div class="flex items-center gap-3">
            {{-- Handle Grip --}}
            <div class="drag-handle cursor-move text-gray-400 hover:text-primary p-1">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>

            <div>
                <div class="font-bold text-gray-800 text-sm flex items-center gap-2">
                    {{ $item->getTranslation('label', 'id') }}
                    
                    @if(!$item->is_active)
                        <span class="text-[10px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Hidden</span>
                    @endif
                </div>
                <div class="text-xs text-gray-400 flex items-center gap-1">
                    @if($item->type === 'page')
                        <span class="bg-blue-50 text-blue-600 px-1 rounded">Page</span>
                    @else
                        <span class="bg-green-50 text-green-600 px-1 rounded">Link</span>
                    @endif
                    <span class="truncate max-w-[150px]">{{ $item->link }}</span>
                </div>
            </div>
        </div>

        {{-- KANAN: ACTIONS --}}
        <div class="flex items-center gap-2">
            
            {{-- TOGGLE ACTIVE/INACTIVE (Form Kecil) --}}
            <form action="{{ route('admin.menus.update', $item) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="label[id]" value="{{ $item->getTranslation('label', 'id') }}"> {{-- Dummy data --}}
                <input type="hidden" name="is_active" value="{{ $item->is_active ? '0' : '1' }}"> {{-- Flip Logic --}}
                
                {{-- Tombol Mata --}}
                <button type="submit" class="p-1.5 rounded-md hover:bg-gray-100 text-gray-400 hover:text-gray-700 transition-colors" title="Toggle Visibility">
                    @if($item->is_active)
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    @else
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29" /></svg>
                    @endif
                </button>
            </form>

            {{-- DELETE --}}
            <form action="{{ route('admin.menus.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this menu item?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- ANAK MENU (RECURSIVE) --}}
    {{-- Ini wadah buat anak-anaknya. Class 'sortable-list' penting biar SortableJS tau ini zona drop --}}
    <ol class="sortable-list">
        @if($item->children->isNotEmpty())
            @foreach($item->children as $child)
                @include('admin.menus._item', ['item' => $child])
            @endforeach
        @endif
    </ol>
</li>