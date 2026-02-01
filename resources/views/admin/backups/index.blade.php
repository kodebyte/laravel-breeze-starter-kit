<x-admin.layouts.app title="Backup Manager">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'System' => '#', 
                    'Backups' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Database & System Backups
                </h2>
            </div>

            {{-- Create Action --}}
            <form action="{{ route('admin.backups.create') }}" method="POST">
                @csrf
                <x-admin.ui.button type="submit" color="primary">
                    <x-admin.icon.plus class="w-4 h-4 mr-2" />
                    Create New Backup
                </x-admin.ui.button>
            </form>
        </div>
    </x-slot>

    <div class="space-y-6">
        
        {{-- SINGLE CARD LAYOUT --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            {{-- Toolbar Info (Optional: Bisa buat status disk space) --}}
            <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2 text-sm text-gray-600">
                <x-admin.icon.info class="w-4 h-4 text-primary" />
                <span>Backups are stored securely in <strong>{{ config('backup.backup.name') }}</strong> folder.</span>
            </div>

            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th label="Backup File Name" />
                    <x-admin.table.th label="File Size" />
                    <x-admin.table.th label="Created At" />
                    <x-admin.table.th label="Age" />
                    <x-admin.table.th class="relative"><span class="sr-only">Actions</span></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($backups as $backup)
                        <x-admin.table.tr>
                            
                            {{-- 1. FILE NAME (Icon Database) --}}
                            <x-admin.table.td>
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                                        {{-- Icon Database --}}
                                        <x-admin.icon.database class="w-5 h-5" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900 text-sm">
                                            {{ $backup['name'] }}
                                        </span>
                                        <span class="text-xs text-gray-400">System Backup</span>
                                    </div>
                                </div>
                            </x-admin.table.td>

                            {{-- 2. SIZE --}}
                            <x-admin.table.td>
                                <span class="font-mono text-xs font-bold bg-gray-50 px-2 py-1 rounded border border-gray-200 text-gray-700">
                                    {{ $backup['size'] }}
                                </span>
                            </x-admin.table.td>

                            {{-- 3. DATE --}}
                            <x-admin.table.td>
                                {{ $backup['date']->format('d M Y, H:i') }}
                            </x-admin.table.td>

                            {{-- 4. AGE --}}
                            <x-admin.table.td>
                                <span class="text-xs text-gray-500">
                                    {{ $backup['date']->diffForHumans() }}
                                </span>
                            </x-admin.table.td>

                            {{-- 5. ACTIONS --}}
                            <x-admin.table.td class="text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    {{-- Download Button --}}
                                    <x-admin.ui.action-download :href="route('admin.backups.download', ['file_name' => $backup['name']])" />
                                    
                                    {{-- Delete Button (Pakai Component yang udah kita upgrade) --}}
                                    <x-admin.ui.action-delete :action="route('admin.backups.destroy', ['file_name' => $backup['name']])" />
                                </div>
                            </x-admin.table.td>

                        </x-admin.table.tr>
                    @empty
                        {{-- EMPTY STATE --}}
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <x-admin.icon.database class="w-8 h-8 text-gray-300" />
                                    </div>
                                    <h3 class="text-gray-900 font-bold text-lg">No Backups Found</h3>
                                    <p class="text-gray-500 text-sm mt-1 max-w-sm mx-auto mb-4">
                                        It seems you haven't created any backups yet. Better safe than sorry!
                                    </p>
                                    
                                    {{-- Call to Action kalau kosong --}}
                                    <form action="{{ route('admin.backups.create') }}" method="POST">
                                        @csrf
                                        <x-admin.ui.button type="submit" color="primary" size="sm">
                                            Create First Backup
                                        </x-admin.ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>
            
            {{-- Footer Info --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-500">
                    Total Backups: <span class="font-bold text-gray-900">{{ count($backups) }}</span>
                </p>
                <p class="text-xs text-gray-400 italic">
                    * Backups are automatically sorted by newest date.
                </p>
            </div>
        </div>
    </div>
</x-admin.layouts.app>