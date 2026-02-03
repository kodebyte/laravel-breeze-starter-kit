<x-admin.layouts.app title="Banner Manager">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Banner System' => '#', 'All Banners' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Banner Manager
                </h2>
            </div>
            <x-admin.ui.link-button href="{{ route('admin.banners.create') }}">
                <x-admin.icon.plus class="w-4 h-4 mr-2" />
                Add New Banner
            </x-admin.ui.link-button>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
        <x-admin.table>
            <x-admin.table.thead>
                <x-admin.table.th class="w-20">Preview</x-admin.table.th>
                <x-admin.table.th label="Banner Info" />
                <x-admin.table.th label="Zone / Location" />
                <x-admin.table.th label="Order" />
                <x-admin.table.th label="Status" />
                <x-admin.table.th class="text-right"></x-admin.table.th>
            </x-admin.table.thead>

            <x-admin.table.tbody>
                @forelse($banners as $banner)
                    <x-admin.table.tr>
                        {{-- Preview --}}
                        <x-admin.table.td>
                            <div class="h-12 w-20 rounded bg-gray-100 border border-gray-200 overflow-hidden relative group">
                                <img src="{{ asset('storage/' . $banner->image_desktop) }}" class="w-full h-full object-cover">
                                @if($banner->type === 'video')
                                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                                        <x-admin.icon.video class="w-5 h-5 text-white" />
                                    </div>
                                @endif
                            </div>
                        </x-admin.table.td>

                        {{-- Info --}}
                        <x-admin.table.td>
                            <div class="font-bold text-gray-900 line-clamp-1">{{ $banner->title ?? 'Untitled Banner' }}</div>
                            <div class="text-xs text-gray-500 line-clamp-1">{{ $banner->subtitle ?? 'No description' }}</div>
                        </x-admin.table.td>

                        {{-- Zone --}}
                        <x-admin.table.td>
                            @php
                                $zoneConfig = $banner->getZones()[$banner->zone] ?? null;
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $zoneConfig['name'] ?? $banner->zone }}
                            </span>
                        </x-admin.table.td>

                        {{-- Order --}}
                        <x-admin.table.td>
                            <span class="font-mono text-xs text-gray-500">#{{ $banner->order }}</span>
                        </x-admin.table.td>

                        {{-- Status --}}
                        <x-admin.table.td>
                            @if($banner->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-500">
                                    Inactive
                                </span>
                            @endif
                        </x-admin.table.td>

                        {{-- Actions --}}
                        <x-admin.table.td class="text-right font-medium">
                            <div class="flex justify-end gap-3">
                                <x-admin.ui.action-edit :href="route('admin.banners.edit', $banner)" />
                                <x-admin.ui.action-delete :action="route('admin.banners.destroy', $banner)" />
                            </div>
                        </x-admin.table.td>
                    </x-admin.table.tr>
                @empty
                    <x-admin.table.empty colspan="6" :create-route="route('admin.banners.create')" />
                @endforelse
            </x-admin.table.tbody>
        </x-admin.table>

        <x-admin.table.footer :data="$banners" />
    </div>
</x-admin.layouts.app>