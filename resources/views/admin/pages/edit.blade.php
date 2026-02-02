<x-admin.layouts.app title="Edit Page SEO">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Content Management' => '#',
                    'Static Pages' => route('admin.pages.index'),
                    'Edit SEO' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Edit SEO: <span class="text-primary">{{ $page->name }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- SECTION 1: PAGE INFORMATION --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center gap-2 mb-6">
                    <div class="p-2 bg-blue-50 text-primary rounded-lg">
                        <x-admin.icon.template class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Page Information</h3>
                        <p class="text-xs text-gray-500">System details (Read-only).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-admin.form.group label="Page Name" name="name">
                        <x-admin.form.input name="name" :value="$page->name" disabled class="bg-gray-50 text-gray-500 cursor-not-allowed" />
                    </x-admin.form.group>

                    <x-admin.form.group label="URL Slug" name="slug">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 sm:text-sm">/</span>
                            </div>
                            <x-admin.form.input name="slug" :value="$page->slug" disabled class="pl-6 bg-gray-50 text-gray-500 cursor-not-allowed font-mono text-sm" />
                        </div>
                    </x-admin.form.group>
                </div>
            </div>
        </div>

        {{-- SECTION 2: CONTENT EDITOR (LOGIC HYBRID) --}}
        @if($page->is_editable)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6" x-data="{ lang: 'id' }">
                {{-- Header + Lang Switcher --}}
                <div class="p-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            {{-- Icon Document-Text --}}
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Page Content</h3>
                        </div>
                    </div>
                    
                    {{-- Switcher --}}
                    <div class="flex bg-white rounded-lg p-1 border border-gray-200 shadow-sm">
                        <button type="button" @click="lang = 'id'" 
                            :class="lang === 'id' ? 'bg-purple-50 text-purple-600 border-purple-100' : 'text-gray-400 hover:text-gray-600 border-transparent'"
                            class="px-3 py-1 text-xs font-bold rounded border transition-all flex items-center gap-2">
                            <span>🇮🇩</span> ID
                        </button>
                        <div class="w-px bg-gray-200 my-1"></div>
                        <button type="button" @click="lang = 'en'"
                            :class="lang === 'en' ? 'bg-purple-50 text-purple-600 border-purple-100' : 'text-gray-400 hover:text-gray-600 border-transparent'"
                            class="px-3 py-1 text-xs font-bold rounded border transition-all flex items-center gap-2">
                            <span>🇬🇧</span> EN
                        </button>
                    </div>
                </div>

                {{-- Editor Container --}}
                <div class="p-6">
                    {{-- EDITOR INDONESIA --}}
                    <div x-show="lang === 'id'">
                        <textarea id="editor_id" name="content[id]" class="w-full h-96 opacity-0">
                            {!! old('content.id', $page->getTranslation('content', 'id')) !!}
                        </textarea>
                    </div>

                    {{-- EDITOR ENGLISH --}}
                    <div x-show="lang === 'en'" style="display: none;">
                        <textarea id="editor_en" name="content[en]" class="w-full h-96 opacity-0">
                            {!! old('content.en', $page->getTranslation('content', 'en')) !!}
                        </textarea>
                    </div>
                </div>
            </div>
        @else
            {{-- INFO BOX UNTUK HALAMAN CUSTOM (About/Home) --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6 p-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex gap-3">
                    <x-admin.icon.info class="w-5 h-5 text-yellow-600 shrink-0" />
                    <div>
                        <h4 class="font-bold text-yellow-800 text-sm">Custom Layout Detected</h4>
                        <p class="text-xs text-yellow-700 mt-1 leading-relaxed">
                            Content for <span class="font-bold">"{{ $page->name }}"</span> is managed directly via code (Blade View) to maintain the complex layout design (Slider, Grid, Parallax, etc). 
                            <br>You can only update the SEO settings here.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- SECTION 3: SEO COMPONENT --}}
        <x-admin.form.seo-section :model="$page" />

        {{-- FOOTER ACTIONS --}}
        <div class="mt-6 flex items-center justify-end gap-4 pb-10">
            <a href="{{ route('admin.pages.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                Cancel
            </a>
            <x-admin.ui.button type="submit">
                Save Changes
            </x-admin.ui.button>
        </div>

    </form>

    @push('scripts')
        {{-- Panggil Component Script TinyMCE --}}
        {{-- Kita oper ID textareanya kesini --}}
        <x-admin.scripts.tinymce selector="#editor_id, #editor_en" />
    @endpush

</x-admin.layouts.app>