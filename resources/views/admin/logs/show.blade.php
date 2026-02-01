<x-admin.layouts.app title="Activity Details">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Activity Logs' => route('admin.logs.index'), 
                    'Log Detail' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Activity Details
                </h2>
            </div>
        </div>
    </x-slot>

    {{-- SINGLE CARD LAYOUT --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        
        <div class="p-6 space-y-8">
            
            {{-- SECTION 1: METADATA INFORMATION --}}
            <div>
                {{-- Header Icon Biru (Info) --}}
                <div class="flex items-center gap-2 mb-6">
                    <div class="p-2 bg-blue-50 text-primary rounded-lg">
                        <x-admin.icon.activity class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Event Information</h3>
                        <p class="text-xs text-gray-500">Details about who performed the action and when.</p>
                    </div>
                </div>

                {{-- Grid Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Actor --}}
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Actor / Causer</span>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                {{ substr($log->causer->name ?? 'S', 0, 1) }}
                            </div>
                            <span class="font-bold text-gray-900 text-sm truncate">
                                {{ $log->causer->name ?? 'System / Unknown' }}
                            </span>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Action Type</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium {{ $log->description == 'created' ? 'bg-green-100 text-green-800' : ($log->description == 'deleted' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($log->description) }}
                        </span>
                    </div>

                    {{-- IP Address --}}
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">IP Address</span>
                        <code class="text-sm font-mono text-gray-700 bg-white px-2 py-0.5 rounded border border-gray-200">
                            {{ $log->properties['ip'] ?? 'N/A' }}
                        </code>
                    </div>

                    {{-- Timestamp --}}
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Timestamp</span>
                        <span class="font-bold text-gray-900 text-sm">
                            {{ $log->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- PEMISAH ANTAR SECTION --}}
            <div class="border-t border-gray-100"></div>

            {{-- SECTION 2: DATA COMPARISON (TABLE) --}}
            <div>
                {{-- Header Icon Ungu (Database) --}}
                <div class="flex items-center gap-2 mb-6">
                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                        {{-- Anggap aja icon database / changes --}}
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Data Comparison</h3>
                        <p class="text-xs text-gray-500">Review the specific changes made to the record.</p>
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Field Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Old Value</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">New Value</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $attributes = $log->properties['attributes'] ?? [];
                                $oldValues = $log->properties['old'] ?? [];
                            @endphp

                            @forelse($attributes as $key => $newValue)
                                @php 
                                    $oldValue = $oldValues[$key] ?? null;
                                    if(in_array($key, ['updated_at', 'id', 'created_at', 'password', 'remember_token'])) continue;
                                @endphp

                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700 capitalize">
                                        {{ str_replace('_', ' ', $key) }}
                                    </td>
                                    
                                    {{-- Kolom Lama --}}
                                    <td class="px-6 py-4 text-sm text-gray-500 break-all">
                                        @if($oldValue !== $newValue && !is_null($oldValue))
                                            <span class="bg-red-50 text-red-600 px-2 py-1 rounded line-through text-xs font-mono">
                                                {{ is_array($oldValue) ? json_encode($oldValue) : $oldValue }}
                                            </span>
                                        @elseif(is_null($oldValue))
                                            <span class="text-gray-300 italic">-</span>
                                        @else
                                            <span class="text-gray-400 italic">No change</span>
                                        @endif
                                    </td>

                                    {{-- Kolom Baru --}}
                                    <td class="px-6 py-4 text-sm break-all">
                                        <span class="{{ $oldValue !== $newValue ? 'bg-green-50 text-green-700 px-2 py-1 rounded font-bold' : 'text-gray-900' }}">
                                            {{ is_array($newValue) ? json_encode($newValue) : $newValue }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">
                                        No specific attribute changes recorded.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- FOOTER CARD --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end">
            <x-admin.ui.link-button href="{{ route('admin.logs.index') }}" color="gray">
                <x-admin.icon.undo class="w-4 h-4 mr-2" /> Back to List
            </x-admin.ui.link-button>
        </div>
        
    </div>
</x-admin.layouts.app>