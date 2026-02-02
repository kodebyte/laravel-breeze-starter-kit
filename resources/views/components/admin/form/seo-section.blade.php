@props(['model' => null])

{{-- Setup Data SEO --}}
@php
    $seo = $model?->seo;
@endphp

<div x-data="{ 
        activeTab: 'general',
        language: 'id', // Default Bahasa
        flags: {
            'id': '🇮🇩',
            'en': '🇬🇧'
        }
    }" 
    class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">

    {{-- HEADER --}}
    <div class="p-4 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        {{-- KIRI: JUDUL --}}
        <h3 class="font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            SEO Settings
        </h3>
        
        {{-- KANAN: CONTROLS (TABS & LANGUAGE) --}}
        <div class="flex items-center gap-3">
            
            {{-- 1. TABS (Sekarang di kiri/duluan) --}}
            <div class="flex bg-white rounded-lg p-1 border border-gray-200">
                <button type="button" @click="activeTab = 'general'" 
                    :class="activeTab === 'general' ? 'bg-gray-100 text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'"
                    class="px-3 py-1 text-xs rounded-md transition-all">
                    General
                </button>
                <button type="button" @click="activeTab = 'social'"
                    :class="activeTab === 'social' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-500 hover:text-gray-700'"
                    class="px-3 py-1 text-xs rounded-md transition-all">
                    Social (OG)
                </button>
            </div>

            {{-- Divider --}}
            <div class="hidden sm:block w-px h-6 bg-gray-300"></div>

            {{-- 2. LANGUAGE SWITCHER (Sekarang di paling kanan) --}}
            <div class="flex bg-white rounded-lg p-1 border border-gray-200 shadow-sm">
                <button type="button" @click="language = 'id'" 
                    :class="language === 'id' ? 'bg-red-50 text-red-600 border-red-100' : 'text-gray-400 hover:text-gray-600 border-transparent'"
                    class="px-3 py-1 text-xs font-bold rounded border transition-all flex items-center gap-2">
                    <span>🇮🇩</span> ID
                </button>
                <div class="w-px bg-gray-200 my-1"></div>
                <button type="button" @click="language = 'en'"
                    :class="language === 'en' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'text-gray-400 hover:text-gray-600 border-transparent'"
                    class="px-3 py-1 text-xs font-bold rounded border transition-all flex items-center gap-2">
                    <span>🇬🇧</span> EN
                </button>
            </div>

        </div>
    </div>

    <div class="p-6">
        {{-- TAB 1: GENERAL SEO --}}
        <div x-show="activeTab === 'general'" class="space-y-5">
            
            {{-- META TITLE --}}
            <x-admin.form.group label="Meta Title" name="seo_title">
                {{-- Input ID --}}
                <div x-show="language === 'id'">
                    <x-admin.form.input 
                        name="seo[title][id]" 
                        :value="old('seo.title.id', $seo?->getTranslation('title', 'id') ?? '')" 
                        placeholder="{{ $model->title ?? 'Judul halaman...' }} (Bahasa Indonesia)" />
                </div>
                {{-- Input EN --}}
                <div x-show="language === 'en'" style="display: none;">
                    <x-admin.form.input 
                        name="seo[title][en]" 
                        :value="old('seo.title.en', $seo?->getTranslation('title', 'en') ?? '')" 
                        placeholder="{{ $model->title ?? 'Page title...' }} (English)" />
                </div>
                <p class="text-[10px] text-gray-400 mt-1 flex items-center gap-1">
                    Editing: <span x-text="flags[language]" class="text-sm"></span> <span x-text="language.toUpperCase()"></span> version.
                </p>
            </x-admin.form.group>

            {{-- META DESCRIPTION --}}
            <x-admin.form.group label="Meta Description" name="seo_description">
                {{-- Input ID --}}
                <div x-show="language === 'id'">
                    <textarea name="seo[description][id]" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 transition-colors text-sm"
                        placeholder="Rangkuman konten untuk hasil pencarian Google...">{{ old('seo.description.id', $seo?->getTranslation('description', 'id') ?? '') }}</textarea>
                </div>
                {{-- Input EN --}}
                <div x-show="language === 'en'" style="display: none;">
                    <textarea name="seo[description][en]" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 transition-colors text-sm"
                        placeholder="Content summary for Google search results...">{{ old('seo.description.en', $seo?->getTranslation('description', 'en') ?? '') }}</textarea>
                </div>
            </x-admin.form.group>

            {{-- ROBOTS / VISIBILITY --}}
            <x-admin.form.group label="Search Engine Visibility" name="seo_robots">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    {{-- Opsi: Index (Default) vs Noindex (Hidden) --}}
                    <label class="relative flex items-start p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                        <div class="flex items-center h-5">
                            <input type="radio" name="seo[robots]" value="index, follow" 
                                class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                                {{ ($seo->robots ?? 'index, follow') === 'index, follow' ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <span class="font-bold text-gray-900 block">✅ Index, Follow</span>
                            <span class="text-xs text-gray-500">Allow Google to show this page.</span>
                        </div>
                    </label>

                    <label class="relative flex items-start p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-all has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
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
                <p class="text-[10px] text-gray-400 mt-2">
                    Controls the <code>&lt;meta name="robots"&gt;</code> tag.
                </p>
            </x-admin.form.group>

            {{-- CANONICAL URL --}}
            <x-admin.form.group label="Canonical URL (Optional)" name="seo_canonical_url">
                <x-admin.form.input id="seo_canonical_url" name="seo[canonical_url]" type="url" 
                    :value="old('seo.canonical_url', $seo->canonical_url ?? '')" 
                    placeholder="https://..." />
            </x-admin.form.group>
        </div>

        {{-- TAB 2: SOCIAL MEDIA (OG) --}}
        <div x-show="activeTab === 'social'" style="display: none;" class="space-y-4">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- Form Upload --}}
                <div class="flex-1 space-y-4">
                    <x-admin.form.group label="Social Image (OG Image)" name="seo_image">
                        <input type="file" name="seo_image" 
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all border border-gray-300 rounded-lg p-1" />
                        <p class="text-[10px] text-gray-400 mt-1">Image is shared across all languages.</p>
                    </x-admin.form.group>
                </div>

                {{-- Preview --}}
                <div class="w-full md:w-72">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">Social Preview</p>
                    <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                        <div class="h-32 bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($seo?->image)
                                <img src="{{ asset($seo->image) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            @endif
                        </div>
                        <div class="p-3 bg-white">
                            <div class="text-xs text-gray-500 mb-1">{{ request()->getHost() }}</div>
                            <div class="text-sm font-bold text-gray-900 truncate">
                                <span x-show="language === 'id'">{{ $seo?->getTranslation('title', 'id') ?? 'Judul Halaman' }}</span>
                                <span x-show="language === 'en'">{{ $seo?->getTranslation('title', 'en') ?? 'Page Title' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>