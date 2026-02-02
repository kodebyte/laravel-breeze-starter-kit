<x-admin.layouts.app title="Inbox Messages">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                {{-- BREADCRUMB ADDED --}}
                <x-admin.ui.breadcrumb :links="[
                    'Inbox Messages' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Inbox Messages
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            {{-- SEARCH BAR --}}
            <div class="p-4 border-b border-gray-100 flex justify-end">
                <x-admin.form.search placeholder="Search sender or subject..." />
            </div>

            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th-sortable name="is_read" label="Status" />
                    <x-admin.table.th-sortable name="name" label="Sender" />
                    <x-admin.table.th-sortable name="subject" label="Subject" />
                    <x-admin.table.th-sortable name="created_at" label="Date" />
                    <x-admin.table.th class="text-right"></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($inquiries as $inquiry)
                        <x-admin.table.tr>
                            
                            {{-- Status Badge --}}
                            <x-admin.table.td>
                                @if(!$inquiry->is_read)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-700">
                                        NEW
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500">
                                        Read
                                    </span>
                                @endif
                            </x-admin.table.td>

                            {{-- Sender --}}
                            <x-admin.table.td>
                                <div class="font-bold text-gray-900">{{ $inquiry->name }}</div>
                                <div class="text-xs text-gray-500">{{ $inquiry->email }}</div>
                            </x-admin.table.td>

                            {{-- Subject --}}
                            <x-admin.table.td>
                                <div class="text-sm text-gray-900 font-medium truncate max-w-xs">
                                    {{ $inquiry->subject ?? '(No Subject)' }}
                                </div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">
                                    {{ Str::limit($inquiry->message, 50) }}
                                </div>
                            </x-admin.table.td>

                            {{-- Date --}}
                            <x-admin.table.td class="text-xs text-gray-500">
                                {{ $inquiry->created_at->format('d M Y, H:i') }}
                            </x-admin.table.td>

                            {{-- Actions --}}
                            <x-admin.table.td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Action View --}}
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" 
                                       class="p-1.5 bg-white border border-gray-300 rounded-lg text-gray-600 hover:text-primary hover:border-primary transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>

                                    {{-- Action Delete --}}
                                    @can('inquiries.delete')
                                        <x-admin.ui.action-delete :action="route('admin.inquiries.destroy', $inquiry)" />
                                    @endcan
                                </div>
                            </x-admin.table.td>

                        </x-admin.table.tr>
                    @empty
                        <x-admin.table.empty colspan="5" />
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>
            
            {{-- FOOTER WITH PAGINATION & INFO --}}
            <x-admin.table.footer :data="$inquiries" />

        </div>
    </div>
</x-admin.layouts.app>