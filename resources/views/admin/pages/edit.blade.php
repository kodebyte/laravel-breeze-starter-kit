<x-admin.layouts.app title="Edit Page SEO">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'System' => '#',
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

        {{-- SINGLE CARD LAYOUT (Mirip User Edit) --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 space-y-8">
                
                {{-- SECTION 1: PAGE INFORMATION (Read Only) --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            {{-- Icon Template/Layout --}}
                            <x-admin.icon.template class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Page Information</h3>
                            <p class="text-xs text-gray-500">System details (Read-only).</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Name (Disabled) --}}
                        <x-admin.form.group label="Page Name" name="name">
                            <x-admin.form.input name="name" :value="$page->name" disabled class="bg-gray-50 text-gray-500 cursor-not-allowed" />
                        </x-admin.form.group>

                        {{-- Slug (Disabled) --}}
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

                {{-- PEMISAH ANTAR SECTION --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 2: GENERAL SEO --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                            {{-- Icon Search/Globe --}}
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Search Engine Optimization</h3>
                            <p class="text-xs text-gray-500">Improve your ranking on Google search results.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        {{-- Meta Title --}}
                        <x-admin.form.group label="Meta Title" name="seo_title">
                            <x-admin.form.input name="seo[title]" :value="old('seo.title', $page->seo->title ?? '')" placeholder="{{ $page->name }}" />
                            <p class="text-[10px] text-gray-400 mt-1">Leave empty to use the default page name.</p>
                        </x-admin.form.group>

                        {{-- Meta Description --}}
                        <x-admin.form.group label="Meta Description" name="seo_description">
                            <textarea name="seo[description]" rows="3"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 transition-colors text-sm"
                                placeholder="Summarize this page content for search results...">{{ old('seo.description', $page->seo->description ?? '') }}</textarea>
                            <p class="text-[10px] text-gray-400 mt-1">Recommended length: 150-160 characters.</p>
                        </x-admin.form.group>

                        {{-- Canonical URL --}}
                        <x-admin.form.group label="Canonical URL (Optional)" name="seo_canonical">
                             <x-admin.form.input name="seo[canonical_url]" :value="old('seo.canonical_url', $page->seo->canonical_url ?? '')" placeholder="https://" />
                        </x-admin.form.group>
                    </div>
                </div>

                {{-- PEMISAH ANTAR SECTION --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 3: SOCIAL MEDIA (OG) --}}
                <div x-data="{ imagePreview: '{{ $page->seo->image ? asset($page->seo->image) : '' }}' }">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            {{-- Icon Share/Image --}}
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Social Media Share</h3>
                            <p class="text-xs text-gray-500">Customize how this page looks when shared on WhatsApp/Instagram.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Upload Form --}}
                        <div class="space-y-4">
                            <x-admin.form.group label="Social Image (OG Image)" name="seo_image">
                                <input type="file" name="seo_image" 
                                    @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all border border-gray-300 rounded-lg p-1" />
                                <p class="text-[10px] text-gray-400 mt-1">Recommended size: 1200x630 pixels.</p>
                            </x-admin.form.group>
                        </div>

                        {{-- Preview Box --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Preview</label>
                            <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50 aspect-video flex items-center justify-center relative">
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!imagePreview">
                                    <div class="text-center text-gray-400">
                                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-xs">No image uploaded</span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- FOOTER CARD --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.pages.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <x-admin.ui.button type="submit">
                    Save Changes
                </x-admin.ui.button>
            </div>
            
        </div>
    </form>
</x-admin.layouts.app>