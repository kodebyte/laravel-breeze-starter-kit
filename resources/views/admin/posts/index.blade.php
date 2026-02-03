<x-admin.layouts.app title="All Articles">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Blog System' => '#', 'Posts' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    All Articles
                </h2>
            </div>
            @can('posts.create')
                <x-admin.ui.link-button href="{{ route('admin.posts.create') }}">
                    <x-admin.icon.plus class="w-4 h-4 mr-2" />
                    Write Article
                </x-admin.ui.link-button>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            {{-- TOOLBAR: Search & Filter --}}
            <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                
                {{-- Filter Category --}}
                <form method="GET" action="{{ route('admin.posts.index') }}" class="flex items-center gap-2">
                    {{-- Keep existing search/sort params --}}
                    @foreach(request()->except(['category', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <select name="category" onchange="this.form.submit()" class="text-sm rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 shadow-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->getTranslation('name', 'id') }}
                            </option>
                        @endforeach
                    </select>
                </form>

                {{-- Search Bar --}}
                <x-admin.form.search placeholder="Search title..." />
            </div>

            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th class="w-16">Img</x-admin.table.th>
                    <x-admin.table.th-sortable name="title" label="Article Info" />
                    <x-admin.table.th label="Category & Author" />
                    <x-admin.table.th-sortable name="status" label="Status" />
                    <x-admin.table.th-sortable name="published_at" label="Published" />
                    <x-admin.table.th class="text-right"></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($posts as $post)
                        <x-admin.table.tr>
                            
                            {{-- Thumbnail --}}
                            <x-admin.table.td>
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-300">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                            </x-admin.table.td>

                            {{-- Title & Excerpt --}}
                            <x-admin.table.td>
                                <div class="font-bold text-gray-900 line-clamp-1">
                                    {{ $post->getTranslation('title', 'id') }}
                                </div>
                                @if($post->getTranslation('title', 'en'))
                                    <div class="text-[10px] text-gray-400 italic line-clamp-1">
                                        {{ $post->getTranslation('title', 'en') }}
                                    </div>
                                @endif
                            </x-admin.table.td>

                            {{-- Category & Author --}}
                            <x-admin.table.td>
                                <div class="flex flex-col gap-1">
                                    {{-- Category Badge --}}
                                    <span class="inline-flex w-fit items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $post->category->getTranslation('name', 'id') ?? 'Uncategorized' }}
                                    </span>
                                    {{-- Author Name --}}
                                    <div class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        {{ $post->author->name ?? 'Unknown' }}
                                    </div>
                                </div>
                            </x-admin.table.td>

                            {{-- Status Badge (Enum Color) --}}
                            <x-admin.table.td>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold capitalize
                                    bg-{{ $post->status->color() }}-100 text-{{ $post->status->color() }}-700">
                                    {{ $post->status->label() }}
                                </span>
                            </x-admin.table.td>

                            {{-- Published Date --}}
                            <x-admin.table.td class="text-xs text-gray-500">
                                @if($post->published_at)
                                    <div>{{ $post->published_at->format('d M Y') }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $post->published_at->format('H:i') }} WIB</div>
                                @else
                                    <span class="text-gray-400 italic">Draft</span>
                                @endif
                            </x-admin.table.td>

                            {{-- Actions --}}
                            <x-admin.table.td class="text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    @can('posts.update')
                                        <x-admin.ui.action-edit :href="route('admin.posts.edit', $post)" />
                                    @endcan
                                    @can('posts.delete')
                                        <x-admin.ui.action-delete :action="route('admin.posts.destroy', $post)" />
                                    @endcan
                                </div>
                            </x-admin.table.td>

                        </x-admin.table.tr>
                    @empty
                        <x-admin.table.empty 
                            colspan="6" 
                            :create-route="auth()->user()->can('posts.create') ? route('admin.posts.create') : null" 
                        />
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>

            <x-admin.table.footer :data="$posts" />
        </div>
    </div>
</x-admin.layouts.app>