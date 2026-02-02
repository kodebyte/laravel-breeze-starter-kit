<x-admin.layouts.app title="Media Library">
    
    <div x-data="{ 
            uploading: false, 
            progress: 0,
            showPreview: false,
            activeFile: null,
            copyUrl(url) {
                navigator.clipboard.writeText(url);
                alert('URL copied to clipboard!');
            }
         }" 
         class="space-y-6">

        <x-slot name="header">
            <div>
                <x-admin.ui.breadcrumb :links="['System' => '#', 'Media Library' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Media Manager
                </h2>
            </div>
        </x-slot>

        {{-- 1. UPLOAD ZONE --}}
        {{-- HANYA MUNCUL KALAU PUNYA IZIN CREATE --}}
        @can('media.create')
            <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:bg-gray-50 transition-colors relative"
                 @dragover.prevent="uploading = true"
                 @dragleave.prevent="uploading = false"
                 @drop.prevent="uploading = false; document.getElementById('fileInput').files = $event.dataTransfer.files; document.getElementById('uploadForm').submit()">
                
                <form id="uploadForm" action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="fileInput" name="file" class="hidden" onchange="document.getElementById('uploadForm').submit()">
                    
                    <div class="flex flex-col items-center justify-center cursor-pointer" onclick="document.getElementById('fileInput').click()">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-full mb-3">
                            <x-admin.icon.cloud-upload class="w-8 h-8" />
                        </div>
                        <h3 class="text-sm font-bold text-gray-900">Click to upload or drag and drop</h3>
                        <p class="text-xs text-gray-500 mt-1">SVG, PNG, JPG or PDF (max. 10MB)</p>
                    </div>
                </form>
            </div>
        @endcan

        {{-- 2. MAIN CONTENT CARD --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            {{-- A. CARD HEADER: TOOLBAR --}}
            <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                
                {{-- Search Bar --}}
                <form action="{{ route('admin.media.index') }}" method="GET" class="relative w-full sm:w-72">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Find files..." 
                           class="w-full pl-10 pr-10 py-2 rounded-lg border border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm transition-colors">
                    
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    @if(request('search'))
                        <a href="{{ route('admin.media.index', ['type' => request('type')]) }}" 
                           class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400 hover:text-red-500 transition-colors"
                           title="Clear Search">
                            <x-admin.icon.x class="w-4 h-4" />
                        </a>
                    @endif
                </form>

                {{-- Filter Tabs --}}
                <div class="flex items-center gap-1 bg-gray-50 p-1 rounded-lg border border-gray-200">
                    <a href="{{ route('admin.media.index', ['search' => request('search')]) }}" 
                       class="px-4 py-1.5 text-xs font-bold rounded-md transition-all {{ !request('type') ? 'bg-white text-gray-800 shadow-sm ring-1 ring-gray-200' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                       All
                    </a>
                    <a href="{{ route('admin.media.index', ['type' => 'image', 'search' => request('search')]) }}" 
                       class="px-4 py-1.5 text-xs font-bold rounded-md transition-all {{ request('type') == 'image' ? 'bg-white text-gray-800 shadow-sm ring-1 ring-gray-200' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                       Images
                    </a>
                    <a href="{{ route('admin.media.index', ['type' => 'document', 'search' => request('search')]) }}" 
                       class="px-4 py-1.5 text-xs font-bold rounded-md transition-all {{ request('type') == 'document' ? 'bg-white text-gray-800 shadow-sm ring-1 ring-gray-200' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                       Docs
                    </a>
                </div>
            </div>

            {{-- B. CARD BODY: GRID --}}
            <div class="p-6 bg-gray-50/50 min-h-[300px]">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @forelse($mediaItems as $item)
                        <div class="group relative bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all overflow-hidden cursor-pointer aspect-square flex flex-col"
                             @click="showPreview = true; activeFile = {{ \Illuminate\Support\Js::from($item) }}">
                            
                            <div class="flex-1 bg-gray-100 relative overflow-hidden flex items-center justify-center">
                                @if(str_contains($item->mime_type, 'image'))
                                    <img src="{{ $item->getUrl('thumb') }}" 
                                         class="w-full h-full object-cover transition-transform group-hover:scale-105" 
                                         loading="lazy"
                                         onerror="this.src='{{ $item->getUrl() }}'">
                                @else
                                    <div class="text-gray-400">
                                        <x-admin.icon.document class="w-12 h-12" />
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                            </div>

                            <div class="p-3 bg-white border-t border-gray-100">
                                <p class="text-xs font-bold text-gray-700 truncate" title="{{ $item->file_name }}">
                                    {{ $item->file_name }}
                                </p>
                                <p class="text-[10px] text-gray-400 mt-0.5">
                                    {{ $item->human_readable_size }} • {{ $item->created_at->format('d M') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center flex flex-col items-center justify-center">
                            <div class="bg-gray-100 p-4 rounded-full mb-3">
                                <x-admin.icon.collection class="w-8 h-8 text-gray-400" />
                            </div>
                            <p class="text-gray-500 font-medium">No media files found</p>
                            <p class="text-xs text-gray-400 mt-1">Try adjusting your search or upload a new file.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- C. CARD FOOTER: PAGINATION --}}
            @if($mediaItems->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-white">
                    {{ $mediaItems->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

        {{-- PREVIEW MODAL --}}
        <div x-show="showPreview" style="display: none;" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
             x-transition.opacity>
            
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col md:flex-row overflow-hidden" 
                 @click.outside="showPreview = false">
                
                {{-- Preview --}}
                <div class="flex-1 bg-gray-100 flex items-center justify-center p-8 border-r border-gray-200">
                    <template x-if="activeFile && activeFile.mime_type.includes('image')">
                        <img :src="activeFile.original_url" class="max-w-full max-h-[60vh] shadow-lg rounded-lg">
                    </template>
                    <template x-if="activeFile && !activeFile.mime_type.includes('image')">
                        <div class="text-center">
                            <x-admin.icon.document class="w-24 h-24 text-gray-300 mx-auto" />
                            <p class="mt-4 text-gray-500 font-bold">Preview not available for this file type</p>
                        </div>
                    </template>
                </div>

                {{-- Detail Sidebar --}}
                <div class="w-full md:w-80 bg-white p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="font-bold text-lg text-gray-900">File Details</h3>
                            <button @click="showPreview = false" class="text-gray-400 hover:text-gray-600">
                                <x-admin.icon.x class="w-5 h-5" />
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">File Name</label>
                                <p class="text-sm font-medium text-gray-800 break-all" x-text="activeFile ? activeFile.file_name : ''"></p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">Type</label>
                                <p class="text-sm font-medium text-gray-800" x-text="activeFile ? activeFile.mime_type : ''"></p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">Size</label>
                                <p class="text-sm font-medium text-gray-800" x-text="activeFile ? activeFile.human_readable_size : ''"></p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">Full URL</label>
                                <div class="flex mt-1">
                                    <input type="text" class="w-full text-xs border border-gray-200 bg-gray-50 rounded-l-lg px-2 py-1.5 focus:outline-none" 
                                           :value="activeFile ? activeFile.original_url : ''" readonly>
                                    <button @click="copyUrl(activeFile.original_url)" class="bg-gray-100 hover:bg-gray-200 border border-l-0 border-gray-200 px-3 rounded-r-lg text-gray-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Delete Action --}}
                    {{-- HANYA MUNCUL KALAU PUNYA IZIN DELETE --}}
                    @can('media.delete')
                        <div class="pt-6 mt-6 border-t border-gray-100">
                            <form :action="'{{ route('admin.media.destroy', ':id') }}'.replace(':id', activeFile ? activeFile.id : '')" 
                                method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this file permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-bold">
                                    <x-admin.icon.trash class="w-4 h-4 mr-2" />
                                    Delete File
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-admin.layouts.app>