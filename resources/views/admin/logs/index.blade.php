<x-admin.layouts.app title="Activity Logs">
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="['Activity Logs' => '#']" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">System Activity Logs</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            <div class="p-4 border-b border-gray-100 flex justify-end">
                <x-admin.form.search placeholder="Search logs..." />
            </div>

            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th label="Time" />
                    <x-admin.table.th label="User / Actor" />
                    <x-admin.table.th label="Action" />
                    <x-admin.table.th label="IP Address" />
                    <x-admin.table.th class="relative"><span class="sr-only">Actions</span></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($logs as $log)
                        <x-admin.table.tr>
                            <x-admin.table.td class="text-xs text-gray-500">
                                {{ $log->created_at->format('d M Y, H:i:s') }}
                            </x-admin.table.td>
                            <x-admin.table.td>
                                <span class="font-bold text-gray-900">{{ $log->causer->name ?? 'System' }}</span>
                            </x-admin.table.td>
                            <x-admin.table.td>
                                <x-admin.ui.badge :label="$log->description" color="gray" />
                            </x-admin.table.td>
                            <x-admin.table.td class="text-xs font-mono">{{ $log->ip_address }}</x-admin.table.td>
                            <x-admin.table.td class="text-right">
                                <div class="flex justify-end gap-3">
                                    @can('logs.view')
                                        <a href="{{ route('admin.logs.show', $log) }}" class="text-gray-400 hover:text-primary transition-colors" title="View Detail">
                                            <x-admin.icon.eye class="w-5 h-5" />
                                        </a>
                                    @endcan
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