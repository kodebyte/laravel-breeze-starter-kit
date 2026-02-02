<x-admin.layouts.app title="Menu Management">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Content Management' => '#', 
                    'Menu Manager' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Menu Builder
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- KOLOM KIRI: SUMBER MENU --}}
        <div class="space-y-6">
            
            {{-- CARD 1: ADD STATIC PAGE --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <x-admin.icon.template class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Add Page</h3>
                            <p class="text-xs text-gray-500">Add static pages to menu.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.menus.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="page">
                        
                        <div class="space-y-1 max-h-48 overflow-y-auto mb-4 border border-gray-100 rounded-lg p-2 bg-gray-50/50">
                            @foreach($pages as $page)
                                <label class="flex items-center gap-3 p-2 hover:bg-white hover:shadow-sm rounded cursor-pointer transition-all">
                                    <input type="radio" name="page_id" value="{{ $page->id }}" class="text-primary focus:ring-primary border-gray-300">
                                    <span class="text-sm text-gray-700 font-medium">{{ $page->name }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div class="space-y-4">
                            <x-admin.form.group label="Label Name (ID)" name="label_id_page">
                                <x-admin.form.input name="label[id]" placeholder="Contoh: Tentang Kami" required />
                            </x-admin.form.group>
                            <x-admin.form.group label="Label Name (EN)" name="label_en_page">
                                <x-admin.form.input name="label[en]" placeholder="Ex: About Us" />
                            </x-admin.form.group>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100">
                            {{-- BUTTON CONSISTENT --}}
                            <x-admin.ui.button type="submit" class="w-full justify-center">
                                Add to Menu
                            </x-admin.ui.button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- CARD 2: ADD CUSTOM LINK --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Custom Link</h3>
                            <p class="text-xs text-gray-500">External or custom URL.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.menus.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="custom">

                        <div class="space-y-4">
                            <x-admin.form.group label="URL" name="url">
                                <x-admin.form.input name="url" placeholder="https://..." required />
                            </x-admin.form.group>

                            <x-admin.form.group label="Label Name (ID)" name="label_id_custom">
                                <x-admin.form.input name="label[id]" placeholder="Menu Label" required />
                            </x-admin.form.group>

                            <x-admin.form.group label="Label Name (EN)" name="label_en_custom">
                                <x-admin.form.input name="label[en]" placeholder="Menu Label" />
                            </x-admin.form.group>
                            
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="target" value="_blank" id="target_blank" class="rounded border-gray-300 text-primary focus:ring-primary">
                                <label for="target_blank" class="text-xs text-gray-600 font-medium">Open in new tab</label>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100">
                            {{-- BUTTON CONSISTENT --}}
                            <x-admin.ui.button type="submit" class="w-full justify-center">
                                Add Link
                            </x-admin.ui.button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN: MENU TREE (SORTABLE) --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden min-h-[600px] flex flex-col">
                
                {{-- HEADER --}}
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                            <x-admin.icon.menu class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Menu Structure</h3>
                            <p class="text-xs text-gray-500">Drag items to reorder or nest.</p>
                        </div>
                    </div>

                    {{-- TOMBOL SAVE POSITION (UPDATED) --}}
                    {{-- Pake component x-admin.ui.button biar konsisten HITAM --}}
                    {{-- Tambah type="button" biar gak auto submit form --}}
                    <x-admin.ui.button id="save-menu" type="button" class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        <span>Save Position</span>
                    </x-admin.ui.button>
                </div>

                <div class="p-6 bg-gray-50/30 flex-1">
                    <ol id="menu-root" class="sortable-list space-y-3">
                        @foreach($menuItems as $item)
                            @include('admin.menus._item', ['item' => $item])
                        @endforeach
                    </ol>

                    @if($menuItems->isEmpty())
                        <div class="h-full flex flex-col items-center justify-center text-center py-20 opacity-50">
                            <div class="p-4 bg-gray-100 rounded-full mb-3">
                                <x-admin.icon.menu class="w-8 h-8 text-gray-400" />
                            </div>
                            <p class="font-bold text-gray-500">Menu is empty</p>
                            <p class="text-xs text-gray-400">Add items from the left sidebar to start.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 1. Init Nested Sortable
                const nesters = document.querySelectorAll('.sortable-list');
                
                nesters.forEach((el) => {
                    new Sortable(el, {
                        group: 'nested', 
                        animation: 150,
                        fallbackOnBody: true,
                        swapThreshold: 0.65,
                        handle: '.drag-handle', 
                    });
                });

                // 2. Save Logic
                document.getElementById('save-menu').addEventListener('click', function() {
                    const btn = this;
                    // Simpan isi original tombol (karena di dalem component strukturnya bisa beda)
                    const originalContent = btn.innerHTML; 
                    
                    // Ganti text jadi Saving...
                    btn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...</span>';
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                    
                    function serializeList(list) {
                        let data = [];
                        [...list.children].forEach(li => {
                            if(li.dataset.id) {
                                let item = { id: li.dataset.id };
                                let subList = li.querySelector('ol');
                                if (subList) {
                                    item.children = serializeList(subList);
                                }
                                data.push(item);
                            }
                        });
                        return data;
                    }

                    const rootList = document.getElementById('menu-root');
                    const treeData = serializeList(rootList);

                    fetch('{{ route("admin.menus.update-tree") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ tree: treeData })
                    })
                    .then(res => res.json())
                    .then(data => {
                        window.location.reload(); 
                    })
                    .catch(err => {
                        alert('Error saving menu');
                        // Balikin tombol kayak awal
                        btn.innerHTML = originalContent;
                        btn.disabled = false;
                        btn.classList.remove('opacity-75', 'cursor-not-allowed');
                    });
                });
            });
        </script>
        
        <style>
            .sortable-list ol {
                padding-left: 2rem; 
                margin-top: 0.75rem;
                padding-bottom: 0.5rem;
                min-height: 10px; 
                border-left: 2px dashed #e2e8f0; 
            }
            .sortable-ghost { 
                opacity: 0.4; 
                background: #eff6ff; 
                border: 1px dashed #3b82f6; 
            }
        </style>
    @endpush
</x-admin.layouts.app>