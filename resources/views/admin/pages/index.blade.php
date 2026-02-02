<x-admin.layouts.app title="Static Pages SEO">
    
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['System' => '#', 'Static Pages' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Page Manager
                </h2>
            </div>
            
            {{-- Tombol Refresh Seeder (Opsional) --}}
            {{-- Kalau lo nambah halaman baru di codingan, user klik ini biar muncul di DB --}}
            <form action="{{ route('admin.pages.sync') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-gray-500 hover:text-primary underline">
                    Sync New Pages
                </button>
            </form>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th label="Page Name" />
                    <x-admin.table.th label="URL Slug" />
                    <x-admin.table.th label="SEO Status" />
                    <x-admin.table.th label="Last Updated" />
                    <x-admin.table.th label="Actions" class="text-right" />
                </x-admin.table.thead>
                
                <x-admin.table.tbody>
                    @forelse($pages as $page)
                        <x-admin.table.tr>
                            {{-- Name --}}
                            <x-admin.table.td>
                                <span class="font-bold text-gray-900">{{ $page->name }}</span>
                            </x-admin.table.td>

                            {{-- Slug --}}
                            <x-admin.table.td>
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200">/{{ $page->slug }}</code>
                            </x-admin.table.td>

                            {{-- SEO Status --}}
                            <x-admin.table.td>
                                @if($page->seo->title)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Customized
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        Default
                                    </span>
                                @endif
                            </x-admin.table.td>

                            {{-- Last Updated --}}
                            <x-admin.table.td class="text-xs text-gray-500">
                                {{ $page->updated_at->diffForHumans() }}
                            </x-admin.table.td>

                            {{-- Actions --}}
                            <x-admin.table.td class="text-right">
                                @can('pages.update')
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                                        Config SEO
                                    </a>
                                @endcan
                            </x-admin.table.td>
                        </x-admin.table.tr>
                    @empty
                        <x-admin.table.empty colspan="5" />
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>

        </div>
    </div>
</x-admin.layouts.app>