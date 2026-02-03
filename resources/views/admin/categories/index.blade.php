<x-admin.layouts.app title="Blog Categories">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Blog System' => '#', 'Categories' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Categories
                </h2>
            </div>
            @can('categories.create')
                <x-admin.ui.link-button href="{{ route('admin.categories.create') }}">
                    <x-admin.icon.plus class="w-4 h-4 mr-2" />
                    Add Category
                </x-admin.ui.link-button>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            {{-- SEARCH BAR --}}
            <div class="p-4 border-b border-gray-100 flex justify-end">
                <x-admin.form.search placeholder="Search category..." />
            </div>

            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th-sortable name="name" label="Category Name" />
                    <x-admin.table.th-sortable name="posts_count" label="Articles" />
                    <x-admin.table.th-sortable name="is_active" label="Status" />
                    <x-admin.table.th-sortable name="created_at" label="Created At" />
                    <x-admin.table.th class="text-right"></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($categories as $category)
                        <x-admin.table.tr>
                            {{-- Name & Slug --}}
                            <x-admin.table.td>
                                <div class="flex items-center gap-3">
                                    {{-- Icon Box --}}
                                    <div class="p-2 bg-blue-50 text-primary rounded-lg flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $category->getTranslation('name', 'id') }}</div>
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">
                                            /{{ $category->slug }}
                                        </div>
                                    </div>
                                </div>
                            </x-admin.table.td>

                            {{-- Posts Count --}}
                            <x-admin.table.td>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $category->posts_count }} Post(s)
                                </span>
                            </x-admin.table.td>

                            {{-- Status --}}
                            <x-admin.table.td>
                                @if($category->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-500">
                                        Inactive
                                    </span>
                                @endif
                            </x-admin.table.td>

                            {{-- Date --}}
                            <x-admin.table.td class="text-xs text-gray-500">
                                {{ $category->created_at->format('d M Y') }}
                            </x-admin.table.td>

                            {{-- Actions --}}
                            <x-admin.table.td class="text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    @can('categories.update')
                                        <x-admin.ui.action-edit :href="route('admin.categories.edit', $category)" />
                                    @endcan
                                    @can('categories.delete')
                                        <x-admin.ui.action-delete :action="route('admin.categories.destroy', $category)" />
                                    @endcan
                                </div>
                            </x-admin.table.td>
                        </x-admin.table.tr>
                    @empty
                        <x-admin.table.empty 
                            colspan="5" 
                            :create-route="auth()->user()->can('categories.create') ? route('admin.categories.create') : null" 
                        />
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>

            <x-admin.table.footer :data="$categories" />
        </div>
    </div>
</x-admin.layouts.app>