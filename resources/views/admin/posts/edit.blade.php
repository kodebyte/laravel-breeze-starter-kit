<x-admin.layouts.app title="Edit Article">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Blog System' => '#', 
                    'Posts' => route('admin.posts.index'),
                    'Edit Article' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Edit: <span class="text-primary">{{ $post->getTranslation('title', 'id') }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- MAIN CONTENT --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden p-6">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            <x-admin.icon.pencil class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Article Details</h3>
                            <p class="text-xs text-gray-500">Edit content information.</p>
                        </div>
                    </div>

                    <x-admin.ui.tab-language>
                        {{-- Slot ID --}}
                        <x-slot name="idContent">
                            {{-- FIX: name="title[id]" --}}
                            <x-admin.form.group label="Title (ID)" name="title[id]" required>
                                <x-admin.form.input name="title[id]" :value="old('title.id', $post->getTranslation('title', 'id'))" class="font-bold text-lg" required />
                            </x-admin.form.group>
                            
                            <x-admin.form.group label="Excerpt (ID)" name="excerpt[id]">
                                <x-admin.form.textarea name="excerpt[id]" rows="3">{{ old('excerpt.id', $post->getTranslation('excerpt', 'id')) }}</x-admin.form.textarea>
                            </x-admin.form.group>

                            <div class="border-t border-gray-100 my-4"></div>

                            <x-admin.form.group label="Content (ID)" name="content[id]" required>
                                <textarea id="editor_id" name="content[id]" class="tinymce">{{ old('content.id', $post->getTranslation('content', 'id')) }}</textarea>
                            </x-admin.form.group>
                        </x-slot>

                        {{-- Slot EN --}}
                        <x-slot name="enContent">
                            <x-admin.form.group label="Title (EN)" name="title[en]">
                                <x-admin.form.input name="title[en]" :value="old('title.en', $post->getTranslation('title', 'en'))" class="font-bold text-lg" />
                            </x-admin.form.group>
                            
                            <x-admin.form.group label="Excerpt (EN)" name="excerpt[en]">
                                <x-admin.form.textarea name="excerpt[en]" rows="3">{{ old('excerpt.en', $post->getTranslation('excerpt', 'en')) }}</x-admin.form.textarea>
                            </x-admin.form.group>

                            <div class="border-t border-gray-100 my-4"></div>

                            <x-admin.form.group label="Content (EN)" name="content[en]">
                                <textarea id="editor_en" name="content[en]" class="tinymce">{{ old('content.en', $post->getTranslation('content', 'en')) }}</textarea>
                            </x-admin.form.group>
                        </x-slot>
                    </x-admin.ui.tab-language>
                </div>

                {{-- SEO SECTION (Inject Model) --}}
                <x-admin.form.seo-section :model="$post" :show_robots="false" />

            </div>

            {{-- KOLOM KANAN --}}
            <div class="space-y-6">
                
                {{-- Publish Box --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden p-5">
                    <div class="mb-4">
                        <h3 class="font-bold text-gray-900">Publishing</h3>
                    </div>

                    <div class="space-y-4">
                        <x-admin.form.group label="Status" name="status" required>
                            <x-admin.form.select name="status">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->value }}" {{ old('status', $post->status->value) == $status->value ? 'selected' : '' }}>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </x-admin.form.select>
                        </x-admin.form.group>

                        <x-admin.form.group label="Schedule Date" name="published_at">
                            <x-admin.form.input type="datetime-local" name="published_at" :value="old('published_at', $post->published_at?->format('Y-m-d\TH:i'))" />
                        </x-admin.form.group>
                    </div>

                    <div class="pt-4 mt-4 border-t border-gray-100 flex flex-col gap-3">
                        <x-admin.ui.button type="submit" class="w-full justify-center">Update & Save</x-admin.ui.button>
                        <a href="{{ route('admin.posts.index') }}" class="text-xs text-gray-500 hover:text-gray-900 text-center hover:underline">Cancel Changes</a>
                    </div>
                </div>

                {{-- Organization Box --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden p-5">
                    <div class="mb-4">
                        <h3 class="font-bold text-gray-900">Organization</h3>
                    </div>
                    <x-admin.form.group label="Category" name="category_id" required>
                        <x-admin.form.select name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->getTranslation('name', 'id') }}
                                </option>
                            @endforeach
                        </x-admin.form.select>
                    </x-admin.form.group>
                </div>

                {{-- Featured Image Box --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden p-5">
                    <div class="mb-4">
                        <h3 class="font-bold text-gray-900">Featured Image</h3>
                    </div>

                    <x-admin.form.group label="Cover Image" name="image">
                        
                        {{-- Preview Existing Image --}}
                        @if($post->image)
                            <div class="mb-3 rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-auto object-cover">
                            </div>
                        @endif

                        {{-- Custom Upload Zone --}}
                        <div class="relative group">
                            <div class="border-2 border-dashed border-gray-300 group-hover:border-primary/50 rounded-xl p-6 transition-all text-center bg-gray-50 group-hover:bg-primary/5 cursor-pointer">
                                <input type="file" name="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                <div class="space-y-2 pointer-events-none">
                                    <div class="mx-auto w-10 h-10 bg-white rounded-full shadow-sm border border-gray-100 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                        {{-- Icon Upload/Replace --}}
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-600 group-hover:text-primary">
                                        {{ $post->image ? 'Click to replace image' : 'Click to upload cover' }}
                                    </p>
                                    <p class="text-xs text-gray-400">SVG, PNG, JPG or WEBP</p>
                                </div>
                            </div>
                        </div>
                    </x-admin.form.group>

                    <div class="mt-4 pt-4 border-t border-gray-50">
                        <x-admin.form.group label="Custom Slug (URL)" name="slug">
                            <x-admin.form.input name="slug" :value="old('slug', $post->slug)" class="bg-gray-50 font-mono text-xs" />
                        </x-admin.form.group>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    @push('scripts')
        <x-admin.scripts.tinymce selector="#editor_id, #editor_en" />
    @endpush
    
</x-admin.layouts.app>