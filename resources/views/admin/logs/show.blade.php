<x-admin.layouts.app title="Log Detail: {{ $log->description }}">
    <x-slot name="header">
        {{-- HEADER: Fokus di Navigasi & Judul --}}
        <div>
            <x-admin.ui.breadcrumb :links="['Activity Logs' => route('admin.logs.index'), 'Log Detail' => '#']" />
            <h2 class="font-bold text-xl text-gray-900 leading-tight">
                Activity Details
            </h2>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- KIRI: Data Changes (The Diff Table) - Sekarang di Sisi Lebar --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">Data Comparison</h3>
                </div>

                <x-admin.table>
                    <x-admin.table.thead>
                        <x-admin.table.th label="Field Name" />
                        <x-admin.table.th label="Old Value" />
                        <x-admin.table.th label="New Value" />
                    </x-admin.table.thead>
                    <x-admin.table.tbody>
                        @php
                            $attributes = $log->properties['attributes'] ?? [];
                            $oldValues = $log->properties['old'] ?? [];
                        @endphp

                        @forelse($attributes as $key => $newValue)
                            @php 
                                $oldValue = $oldValues[$key] ?? null;
                                // Abaikan field yang ga perlu (timestamp, id, dll) biar rapi
                                if(in_array($key, ['updated_at', 'id', 'created_at', 'password'])) continue;
                            @endphp

                            <x-admin.table.tr>
                                <x-admin.table.td class="font-bold text-gray-700 capitalize">
                                    {{ str_replace('_', ' ', $key) }}
                                </x-admin.table.td>
                                
                                {{-- Kolom Lama --}}
                                <x-admin.table.td>
                                    @if($oldValue !== $newValue)
                                        <span class="text-red-500 line-through italic">{{ $oldValue ?? 'None' }}</span>
                                    @else
                                        <span class="text-gray-400 italic">No change</span>
                                    @endif
                                </x-admin.table.td>

                                {{-- Kolom Baru --}}
                                <x-admin.table.td>
                                    <span class="{{ $oldValue !== $newValue ? 'text-emerald-600 font-bold' : 'text-gray-900' }}">
                                        {{ is_array($newValue) ? json_encode($newValue) : $newValue }}
                                    </span>
                                </x-admin.table.td>
                            </x-admin.table.tr>
                        @empty
                            <x-admin.table.empty colspan="3" />
                        @endforelse
                    </x-admin.table.tbody>
                </x-admin.table>
            </div>
        </div>

        {{-- KANAN: Actions & Meta Info --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- ACTION CARD: Lokasi baru untuk tombol Back --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <x-admin.ui.link-button href="{{ route('admin.logs.index') }}" color="gray" class="w-full justify-center">
                    <x-admin.icon.undo class="w-4 h-4 mr-2" /> Back to List
                </x-admin.ui.link-button>
            </div>

            {{-- LOG INFORMATION CARD --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Log Information</h3>
                
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="text-gray-400 block">Actor / Causer</span>
                        <span class="font-bold text-gray-900">{{ $log->causer->name ?? 'System' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block">Description</span>
                        <x-admin.ui.badge :label="$log->description" color="gray" />
                    </div>
                    <div>
                        <span class="text-gray-400 block">IP Address</span>
                        <code class="text-xs font-mono bg-gray-50 px-2 py-1 rounded">{{ $log->ip_address }}</code>
                    </div>
                    <div>
                        <span class="text-gray-400 block">Timestamp</span>
                        <span class="text-gray-900">{{ $log->created_at->format('d M Y, H:i:s') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layouts.app>