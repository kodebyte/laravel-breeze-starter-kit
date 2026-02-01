<x-admin.layouts.app title="Activity Logs">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Activity Logs' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    System Activity Logs
                </h2>
            </div>
            {{-- Logs biasanya read-only, gak ada tombol create --}}
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            <div class="p-4 border-b border-gray-100 flex justify-end">
                <x-admin.form.search placeholder="Search log description..." />
            </div>

            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th label="Actor" />
                    <x-admin.table.th label="Action / Subject" />
                    <x-admin.table.th label="IP Address" />
                    <x-admin.table.th-sortable name="created_at" label="Happened At" />
                    <x-admin.table.th class="relative"><span class="sr-only">Actions</span></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($logs as $log)
                        <x-admin.table.tr>
                            
                            {{-- 1. ACTOR --}}
                            <x-admin.table.td>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        {{-- Fallback 'S' for System if causer is null --}}
                                        <x-admin.ui.avatar :name="$log->causer->name ?? 'System'" class="ring-2 ring-white" />
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $log->causer->name ?? 'System / Automated' }}
                                        </div>
                                    </div>
                                </div>
                            </x-admin.table.td>

                            {{-- 2. DESCRIPTION --}}
                            <x-admin.table.td>
                                <span class="font-medium text-gray-700">{{ ucfirst($log->description) }}</span>
                                <span class="text-xs text-gray-400 block mt-0.5">
                                    {{ $log->subject_type }} #{{ $log->subject_id }}
                                </span>
                            </x-admin.table.td>

                            {{-- 3. IP --}}
                            <x-admin.table.td>
                                <code class="text-xs font-mono bg-gray-50 px-2 py-1 rounded text-gray-600 border border-gray-200">
                                    {{ $log->ip_address ?? 'N/A' }}
                                </code>
                            </x-admin.table.td>

                            {{-- 4. DATE --}}
                            <x-admin.table.td>
                                <div class="text-sm text-gray-900">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</div>
                            </x-admin.table.td>

                            {{-- 5. ACTIONS --}}
                            <x-admin.table.td class="text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.logs.show', $log) }}" class="p-1.5 bg-white border border-gray-200 rounded-lg text-gray-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm" title="View Details">
                                        <x-admin.icon.eye class="w-4 h-4" />
                                    </a>
                                </div>
                            </x-admin.table.td>

                        </x-admin.table.tr>
                    @empty
                        <x-admin.table.empty colspan="5" />
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>

            <x-admin.table.footer :data="$logs" />
        </div>
    </div>
</x-admin.layouts.app>