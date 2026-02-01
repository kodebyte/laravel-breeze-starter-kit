<x-admin.layouts.app title="Role Management">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Roles & Permissions' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Role Management
                </h2>
            </div>

            @can('roles.create')
                <x-admin.ui.link-button href="{{ route('admin.roles.create') }}">
                    <x-admin.icon.plus class="w-4 h-4 mr-2" />
                    Add New Role
                </x-admin.ui.link-button>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            {{-- SEARCH SECTION: Standard Kanan (Sesuai User Index) --}}
            <div class="p-4 border-b border-gray-100 flex justify-end">
                <x-admin.form.search placeholder="Search roles..." />
            </div>

            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th label="Role Name" />
                    <x-admin.table.th label="Permissions" />
                    <x-admin.table.th label="Users Count" />
                    <x-admin.table.th class="relative"><span class="sr-only">Actions</span></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($roles as $role)
                        <x-admin.table.tr>
                            {{-- 1. ROLE NAME --}}
                            <x-admin.table.td>
                                <span class="font-bold text-gray-900">{{ $role->name }}</span>
                            </x-admin.table.td>

                            {{-- 2. PERMISSIONS --}}
                            <x-admin.table.td>
                                <div class="flex flex-wrap gap-1">
                                    {{-- Limit 3 permission biar rapi --}}
                                    @foreach($role->permissions->take(3) as $perm)
                                        <x-admin.ui.badge :label="explode('.', $perm->name)[1] ?? $perm->name" color="gray" />
                                    @endforeach
                                    
                                    @if($role->permissions->count() > 3)
                                        <x-admin.ui.badge label="+{{ $role->permissions->count() - 3 }} more" color="gray" />
                                    @endif
                                </div>
                            </x-admin.table.td>

                            {{-- 3. USER COUNT --}}
                            <x-admin.table.td>
                                <x-admin.ui.badge :label="$role->users_count ?? 0 . ' Staff'" color="info" />
                            </x-admin.table.td>

                            {{-- 4. ACTIONS --}}
                            <x-admin.table.td class="text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    {{-- Cegah Edit Super Admin --}}
                                    @if($role->name !== 'Super Admin')
                                        @can('roles.update')
                                            <x-admin.ui.action-edit :href="route('admin.roles.edit', $role)" />
                                        @endcan

                                        @can('roles.delete')
                                            <x-admin.ui.action-delete :action="route('admin.roles.destroy', $role)" />
                                        @endcan
                                    @else
                                        <span class="flex items-center text-xs text-gray-400 italic bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                            <x-admin.icon.shield class="w-3 h-3 mr-1" /> Protected
                                        </span>
                                    @endif
                                </div>
                            </x-admin.table.td>
                        </x-admin.table.tr>
                    @empty
                        <x-admin.table.empty 
                            colspan="4" 
                            :create-route="auth()->user()->can('roles.create') ? route('admin.roles.create') : null" 
                        />
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>
            
            {{-- STANDARD FOOTER --}}
            <x-admin.table.footer :data="$roles" />
        </div>
    </div>
</x-admin.layouts.app>