<x-admin.layouts.app title="Create Banner">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Banner System' => '#', 
                    'Banners' => route('admin.banners.index'),
                    'Create New' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">Create New Banner</h2>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- ALPINE JS LOGIC: Inject Config Zones --}}
        <div x-data="{ 
            zone: 'home_hero', 
            type: 'image',
            zones: {{ json_encode($zones) }}
        }" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- KOLOM KIRI (Media & Settings) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- CARD 1: CONFIGURATION --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            <x-admin.icon.cog class="w-5 h-5" />
                        </div>
                        <h3 class="font-bold text-gray-900">Banner Configuration</h3>
                    </div>

                    <div class="space-y-6">
                        {{-- 1. PILIH ZONA --}}
                        <x-admin.form.group label="Banner Zone" name="zone" required>
                            <select name="zone" x-model="zone" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                <template x-for="(data, key) in zones" :key="key">
                                    <option :value="key" x-text="data.name"></option>
                                </template>
                            </select>
                            {{-- Hint Recommendation --}}
                            <p class="mt-2 text-xs text-blue-600 bg-blue-50 p-2 rounded border border-blue-100 inline-block">
                                💡 Size: <span x-text="zones[zone].recommendation" class="font-bold"></span>
                            </p>
                        </x-admin.form.group>

                        {{-- 2. PILIH TIPE (Hanya muncul jika zona support video) --}}
                        <div x-show="zones[zone].allowed_types.includes('video')" x-transition class="pt-4 border-t border-gray-100">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Content Type</label>
                            <div class="flex gap-4">
                                {{-- Option Image --}}
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="image" x-model="type" class="peer sr-only">
                                    <div class="px-4 py-2 rounded-lg border border-gray-200 peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary transition-all text-sm font-bold text-gray-600 flex items-center gap-2">
                                        <x-admin.icon.image class="w-4 h-4" /> Image Only
                                    </div>
                                </label>
                                {{-- Option Video --}}
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="video" x-model="type" class="peer sr-only">
                                    <div class="px-4 py-2 rounded-lg border border-gray-200 peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary transition-all text-sm font-bold text-gray-600 flex items-center gap-2">
                                        <x-admin.icon.video class="w-4 h-4" /> Video Background
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: MEDIA UPLOAD --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                            <x-admin.icon.image class="w-5 h-5" />
                        </div>
                        <h3 class="font-bold text-gray-900">Media Assets</h3>
                    </div>

                    <div class="space-y-6">
                        {{-- A. VIDEO UPLOAD --}}
                        <div x-show="type === 'video'" x-transition>
                            <x-admin.form.group label="Upload Video (MP4)" name="video" required>
                                <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer relative group">
                                    <input type="file" name="video" accept="video/mp4" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <div class="pointer-events-none group-hover:scale-105 transition-transform">
                                        <x-admin.icon.video class="w-10 h-10 mx-auto text-gray-300 mb-2" />
                                        <p class="text-sm font-medium text-gray-600">Click to upload MP4</p>
                                        <p class="text-xs text-gray-400">Max 10MB. Keep it short & looped.</p>
                                    </div>
                                </div>
                            </x-admin.form.group>
                            
                            <div class="bg-yellow-50 text-yellow-800 text-xs p-3 rounded-lg flex gap-2 items-start border border-yellow-100">
                                <x-admin.icon.info class="w-4 h-4 shrink-0 mt-0.5" />
                                <p><strong>Important:</strong> You MUST upload a Desktop Image below. It serves as the "Poster" while video loads or on mobile power-saving mode.</p>
                            </div>
                        </div>

                        {{-- B. DESKTOP IMAGE (Always Required) --}}
                        <div>
                            <x-admin.form.group label="Desktop Image / Poster" name="image_desktop" required>
                                <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer relative group">
                                    <input type="file" name="image_desktop" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <div class="pointer-events-none group-hover:scale-105 transition-transform">
                                        <x-admin.icon.image class="w-10 h-10 mx-auto text-gray-300 mb-2" />
                                        <p class="text-sm font-medium text-gray-600">Upload Desktop Image</p>
                                        <p class="text-xs text-gray-400">Supported: JPG, PNG, WEBP</p>
                                    </div>
                                </div>
                            </x-admin.form.group>
                        </div>

                        {{-- C. MOBILE IMAGE (Conditional) --}}
                        <div x-show="zones[zone].has_mobile" x-transition class="pt-6 border-t border-gray-100">
                            <x-admin.form.group label="Mobile Image (Optional)" name="image_mobile">
                                <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer relative group">
                                    <input type="file" name="image_mobile" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <div class="pointer-events-none group-hover:scale-105 transition-transform">
                                        <x-admin.icon.mobile class="w-10 h-10 mx-auto text-gray-300 mb-2" />
                                        <p class="text-sm font-medium text-gray-600">Upload Mobile Image (Portrait)</p>
                                        <p class="text-xs text-gray-400">Optimized for small screens</p>
                                    </div>
                                </div>
                            </x-admin.form.group>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN (Text & Publish) --}}
            <div class="space-y-6">
                
                {{-- Publish Box --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden p-5">
                    <h3 class="font-bold text-gray-900 mb-4">Publishing</h3>
                    
                    <div class="space-y-4">
                        <x-admin.form.group label="Status" name="is_active">
                            <select name="is_active" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </x-admin.form.group>
                        
                        <x-admin.form.group label="Sort Order" name="order">
                            <x-admin.form.input type="number" name="order" value="0" />
                        </x-admin.form.group>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col gap-3">
                        <x-admin.ui.button type="submit" class="w-full justify-center">Save Banner</x-admin.ui.button>
                        <a href="{{ route('admin.banners.index') }}" class="text-xs text-gray-500 hover:text-gray-900 text-center hover:underline">Cancel</a>
                    </div>
                </div>

                {{-- Text Overlay --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            <x-admin.icon.pencil class="w-5 h-5" />
                        </div>
                        <h3 class="font-bold text-gray-900">Text Overlay</h3>
                    </div>

                    <div class="space-y-4">
                        <x-admin.form.group label="Title" name="title">
                            <x-admin.form.input name="title" placeholder="Big Promo Title..." />
                        </x-admin.form.group>
                        
                        <x-admin.form.group label="Subtitle" name="subtitle">
                            <x-admin.form.textarea name="subtitle" rows="2" placeholder="Short description..." />
                        </x-admin.form.group>

                        <div class="grid grid-cols-2 gap-3">
                            <x-admin.form.group label="Button Text" name="cta_text">
                                <x-admin.form.input name="cta_text" placeholder="e.g. Shop Now" />
                            </x-admin.form.group>
                            <x-admin.form.group label="Button URL" name="cta_url">
                                <x-admin.form.input name="cta_url" placeholder="https://..." />
                            </x-admin.form.group>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
</x-admin.layouts.app>