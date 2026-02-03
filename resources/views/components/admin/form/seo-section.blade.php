@props([
    'model' => null, 
    'show_robots' => true
])

{{-- Setup Data SEO --}}
@php
    $seo = $model?->seo;
@endphp

<div x-data="{ activeTab: 'general' }" 
    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-6">

    {{-- HEADER CARD --}}
    <div class="p-6 pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        {{-- KIRI: JUDUL --}}
        <div class="flex items-center gap-2">
            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">SEO Settings</h3>
                <p class="text-xs text-gray-500">Search engine optimization.</p>
            </div>
        </div>
        
        {{-- KANAN: TABS (White Capsule) --}}
        <div class="flex bg-white rounded-lg p-1 border border-gray-200 shadow-sm">
            <button type="button" @click="activeTab = 'general'" 
                :class="activeTab === 'general' ? 'bg-gray-100 text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                class="px-3 py-1.5 text-xs font-bold rounded-md transition-all">
                General
            </button>
            <button type="button" @click="activeTab = 'social'"
                :class="activeTab === 'social' ? 'bg-gray-100 text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                class="px-3 py-1.5 text-xs font-bold rounded-md transition-all">
                Social Media
            </button>
        </div>
    </div>

    {{-- CARD BODY --}}
    <div class="p-6">
        
        {{-- TAB 1: GENERAL --}}
        <div x-show="activeTab === 'general'" class="space-y-6">
            
            {{-- LANGUAGE TAB --}}
            <x-admin.ui.tab-language>
                {{-- Slot ID --}}
                <x-slot name="idContent">
                    {{-- FIX: name="seo[title][id]" --}}
                    <x-admin.form.group label="Meta Title (ID)" name="seo[title][id]">
                        <x-admin.form.input name="seo[title][id]" :value="old('seo.title.id', $seo?->getTranslation('title', 'id') ?? '')" placeholder="{{ $model->title ?? 'Judul halaman...' }}" />
                    </x-admin.form.group>
                    
                    {{-- FIX: name="seo[description][id]" --}}
                    <x-admin.form.group label="Meta Description (ID)" name="seo[description][id]">
                        <x-admin.form.textarea name="seo[description][id]" rows="3" placeholder="Deskripsi untuk Google...">{{ old('seo.description.id', $seo?->getTranslation('description', 'id') ?? '') }}</x-admin.form.textarea>
                    </x-admin.form.group>
                </x-slot>

                {{-- Slot EN --}}
                <x-slot name="enContent">
                    {{-- FIX: name="seo[title][en]" --}}
                    <x-admin.form.group label="Meta Title (EN)" name="seo[title][en]">
                        <x-admin.form.input name="seo[title][en]" :value="old('seo.title.en', $seo?->getTranslation('title', 'en') ?? '')" placeholder="{{ $model->title ?? 'Page title...' }}" />
                    </x-admin.form.group>
                    
                    {{-- FIX: name="seo[description][en]" --}}
                    <x-admin.form.group label="Meta Description (EN)" name="seo[description][en]">
                        <x-admin.form.textarea name="seo[description][en]" rows="3" placeholder="Description for Google...">{{ old('seo.description.en', $seo?->getTranslation('description', 'en') ?? '') }}</x-admin.form.textarea>
                    </x-admin.form.group>
                </x-slot>
            </x-admin.ui.tab-language>

            <div class="border-t border-gray-100 pt-6 space-y-6">
                
                {{-- ROBOTS --}}
                @if($show_robots)
                    {{-- FIX: name="seo[robots]" --}}
                    <x-admin.form.group label="Crawling & Indexing" name="seo[robots]">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Option 1: Index --}}
                            <label class="relative flex items-start p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50 has-[:checked]:ring-1 has-[:checked]:ring-green-500">
                                <div class="flex items-center h-5">
                                    <input type="radio" name="seo[robots]" value="index, follow" 
                                        class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                                        {{ ($seo->robots ?? 'index, follow') === 'index, follow' ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold text-gray-900 block">✅ Index, Follow</span>
                                    <span class="text-xs text-gray-500">Allow Google to index this page.</span>
                                </div>
                            </label>

                            {{-- Option 2: No Index --}}
                            <label class="relative flex items-start p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-all has-[:checked]:border-red-500 has-[:checked]:bg-red-50 has-[:checked]:ring-1 has-[:checked]:ring-red-500">
                                <div class="flex items-center h-5">
                                    <input type="radio" name="seo[robots]" value="noindex, nofollow" 
                                        class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500"
                                        {{ ($seo->robots ?? '') === 'noindex, nofollow' ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold text-gray-900 block">🚫 No Index (Hidden)</span>
                                    <span class="text-xs text-gray-500">Hide from search results.</span>
                                </div>
                            </label>
                        </div>
                    </x-admin.form.group>
                @endif

                {{-- CANONICAL --}}
                {{-- FIX: name="seo[canonical_url]" --}}
                <x-admin.form.group label="Canonical URL (Optional)" name="seo[canonical_url]">
                     <x-admin.form.input id="seo_canonical_url" name="seo[canonical_url]" type="url" 
                        :value="old('seo.canonical_url', $seo->canonical_url ?? '')" 
                        placeholder="https://example.com/original-page-url" />
                    <p class="text-[10px] text-gray-400 mt-2">Leave empty to use current URL. Use this if this content is a duplicate of another URL.</p>
                </x-admin.form.group>

            </div>
        </div>

        {{-- TAB 2: SOCIAL MEDIA --}}
        <div x-show="activeTab === 'social'" x-cloak class="space-y-6">
            <div class="flex flex-col md:flex-row gap-8">
                
                {{-- Form Upload (Drag & Drop) --}}
                <div class="flex-1 space-y-4">
                    {{-- Note: name="seo_image" sudah benar karena inputnya seo_image (bukan array) --}}
                    <x-admin.form.group label="Social Share Image (OG Image)" name="seo_image">
                        <div class="relative group">
                            <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:bg-gray-50 transition-colors relative cursor-pointer">
                                <input type="file" name="seo_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                <div class="space-y-2 pointer-events-none">
                                    <div class="mx-auto w-10 h-10 bg-white rounded-full shadow-sm border border-gray-100 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                        <x-admin.icon.image class="w-5 h-5" />
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Click to upload social image</p>
                                    <p class="text-xs text-gray-400">1200 x 630 px recommended</p>
                                </div>
                            </div>
                        </div>
                    </x-admin.form.group>
                </div>

                {{-- Preview Card --}}
                <div class="w-full md:w-80">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-3">Facebook / Twitter Preview</p>
                    <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50 shadow-sm">
                        <div class="h-40 bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($seo?->image)
                                <img src="{{ asset($seo->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-gray-400 flex flex-col items-center">
                                    <x-admin.icon.image class="w-8 h-8 mb-1" />
                                    <span class="text-[10px]">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-3 bg-white">
                            <div class="text-[10px] text-gray-400 uppercase font-semibold mb-1">{{ request()->getHost() }}</div>
                            <div class="text-sm font-bold text-gray-900 truncate mb-1">
                                {{ $seo?->getTranslation('title', 'id') ?? ($model->title ?? 'Page Title') }}
                            </div>
                            <div class="text-xs text-gray-500 line-clamp-2">
                                {{ $seo?->getTranslation('description', 'id') ?? 'Page description will appear here...' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>