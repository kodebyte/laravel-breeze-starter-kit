<x-admin.layouts.app title="New Category">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Blog System' => '#', 
                    'Categories' => route('admin.categories.index'),
                    'Create New' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Create New Category
                </h2>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 space-y-8">
                
                {{-- SECTION 1: GENERAL INFO --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            {{-- Icon Tag --}}
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">General Information</h3>
                            <p class="text-xs text-gray-500">Category name and basic details.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Nama Indonesia --}}
                        <x-admin.form.group label="Name (Bahasa Indonesia)" name="name_id" required>
                            <x-admin.form.input name="name[id]" :value="old('name.id')" placeholder="Contoh: Teknologi" required autofocus />
                        </x-admin.form.group>

                        {{-- Nama Inggris --}}
                        <x-admin.form.group label="Name (English)" name="name_en">
                            <x-admin.form.input name="name[en]" :value="old('name.en')" placeholder="Ex: Technology" />
                        </x-admin.form.group>
                    </div>
                </div>

                <div class="border-t border-gray-100"></div>

                {{-- SECTION 2: SETTINGS --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            <x-admin.icon.cog class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Visibility Settings</h3>
                            <p class="text-xs text-gray-500">Control the visibility of this category.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                            class="rounded border-gray-300 text-primary focus:ring-primary w-5 h-5" checked>
                        <div>
                            <label for="is_active" class="text-sm font-bold text-gray-900 cursor-pointer">Active</label>
                            <p class="text-xs text-gray-500">If unchecked, this category will be hidden from the website.</p>
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
                    Save Category
                </x-admin.ui.button>
            </div>
        </div>
    </form>
</x-admin.layouts.app>