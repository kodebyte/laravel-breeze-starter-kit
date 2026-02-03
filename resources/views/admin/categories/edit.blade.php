<x-admin.layouts.app title="Edit Category">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Blog System' => '#', 
                    'Categories' => route('admin.categories.index'),
                    'Edit Category' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Edit Category: <span class="text-primary">{{ $category->name }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                
                <div class="p-6 space-y-8">
                    
                    {{-- SECTION 1: GENERAL INFO --}}
                    <div>
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-2 bg-blue-50 text-primary rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">General Information</h3>
                                <p class="text-xs text-gray-500">Update category details.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <x-admin.form.group label="Name (Bahasa Indonesia)" name="name_id" required>
                                <x-admin.form.input name="name[id]" :value="old('name.id', $category->getTranslation('name', 'id'))" required />
                            </x-admin.form.group>

                            <x-admin.form.group label="Name (English)" name="name_en">
                                <x-admin.form.input name="name[en]" :value="old('name.en', $category->getTranslation('name', 'en'))" />
                            </x-admin.form.group>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    {{-- SECTION 2: SEO & SETTINGS --}}
                    <div>
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                                <x-admin.icon.globe class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">SEO & Visibility</h3>
                                <p class="text-xs text-gray-500">Manage URL slug and visibility.</p>
                            </div>
                        </div>

                        <div class="space-y-5">
                            {{-- Slug --}}
                            <x-admin.form.group label="URL Slug (Optional)" name="slug">
                                <x-admin.form.input name="slug" :value="old('slug', $category->slug)" class="bg-gray-50 font-mono text-sm text-gray-600" />
                                <p class="text-[10px] text-gray-400 mt-1">Leave as is unless you want to change the URL structure.</p>
                            </x-admin.form.group>

                            {{-- Active Toggle --}}
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                    class="rounded border-gray-300 text-primary focus:ring-primary w-5 h-5" 
                                    {{ $category->is_active ? 'checked' : '' }}>
                                <div>
                                    <label for="is_active" class="text-sm font-bold text-gray-900 cursor-pointer">Active</label>
                                    <p class="text-xs text-gray-500">If unchecked, this category will be hidden.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                        Cancel
                    </a>
                    <x-admin.ui.button type="submit">
                        Update Category
                    </x-admin.ui.button>
                </div>
            </div>
        </form>
    </div>
</x-admin.layouts.app>