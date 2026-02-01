<x-admin.layouts.app title="User Management">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Users' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    User Management
                </h2>
            </div>

            @can('users.create')
                <x-admin.ui.link-button href="{{ route('admin.users.create') }}">
                    <x-admin.icon.plus class="w-4 h-4 mr-2" />
                    Add New User
                </x-admin.ui.link-button>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            <div class="p-4 border-b border-gray-100 flex justify-end">
                <x-admin.form.search placeholder="Search name or email..." />
            </div>

            <x-admin.table>
                <x-admin.table.thead>
                    {{-- Role dihapus, sisa Identity & Date --}}
                    <x-admin.table.th-sortable name="name" label="User Identity" />
                    <x-admin.table.th-sortable name="created_at" label="Joined Date" />
                    <x-admin.table.th class="relative"><span class="sr-only">Actions</span></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($users as $user)
                        <x-admin.table.tr>
                            
                            {{-- 1. Identity --}}
                            <x-admin.table.td>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9">
                                        <x-admin.ui.avatar :name="$user->name" class="ring-2 ring-white" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900 group-hover:text-primary transition-colors">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </x-admin.table.td>

                            {{-- 2. Date --}}
                            <x-admin.table.td>
                                {{ $user->created_at->format('d M Y') }}
                            </x-admin.table.td>

                            {{-- 3. Actions --}}
                            <x-admin.table.td class="text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    @can('users.update')
                                        <x-admin.ui.action-edit :href="route('admin.users.edit', $user)" />
                                    @endcan
                                    
                                    @can('users.delete')
                                        <x-admin.ui.action-delete :action="route('admin.users.destroy', $user)" />
                                    @endcan
                                </div>
                            </x-admin.table.td>

                        </x-admin.table.tr>
                    @empty
                        {{-- Colspan jadi 3 karena kolom role hilang --}}
                        <x-admin.table.empty 
                            colspan="3" 
                            :create-route="auth()->user()->can('users.create') ? route('admin.users.create') : null" 
                        />
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>

            <x-admin.table.footer :data="$users" />
        </div>
    </div>
</x-admin.layouts.app>