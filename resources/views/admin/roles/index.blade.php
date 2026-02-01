<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-end justify-between">
            <div>
                <x-admin.ui.breadcrumb :links="['Roles & Permissions' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">Role Management</h2>
            </div>

            @can('roles.create')
                <x-admin.ui.link-button href="{{ route('admin.roles.create') }}">
                    <x-admin.icon.plus class="w-4 h-4 mr-2" /> Add New Role
                </x-admin.ui.link-button>
            @endcan
        </div>
    </x-slot>

    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <x-admin.table>
            <x-admin.table.thead>
                <x-admin.table.th label="Role Name" />
                <x-admin.table.th label="Permissions" />
                <x-admin.table.th label="Users Count" />
                <x-admin.table.th />
            </x-admin.table.thead>

            <x-admin.table.tbody>
                @forelse($roles as $role)
                    <x-admin.table.tr>
                        <x-admin.table.td>
                            <span class="font-bold text-gray-900">{{ $role->name }}</span>
                        </x-admin.table.td>
                        <x-admin.table.td>
                            <div class="flex flex-wrap gap-1">
                                {{-- Tampilkan 3 permission pertama aja biar rapi --}}
                                @foreach($role->permissions->take(3) as $perm)
                                    <x-admin.ui.badge :label="$perm->name" color="gray" />
                                @endforeach
                                
                                @if($role->permissions->count() > 3)
                                    <x-admin.ui.badge label="+{{ $role->permissions->count() - 3 }} more" color="gray" />
                                @endif
                            </div>
                        </x-admin.table.td>
                        <x-admin.table.td>
                            <x-admin.ui.badge :label="$role->users_count ?? 0 . ' Staff'" color="info" />
                        </x-admin.table.td>
                        <x-admin.table.td class="text-right">
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
                                    <span class="text-xs text-gray-400 italic">System Protected</span>
                                @endif
                            </div>
                        </x-admin.table.td>
                    </x-admin.table.tr>
                @empty
                    <x-admin.table.empty 
                        colspan="5" 
                        :create-route="auth()->user()->can('roles.create') ? route('admin.roles.create') : null" 
                    />
                @endforelse
            </x-admin.table.tbody>
        </x-admin.table>
        
        <x-admin.table.footer :data="$roles" />
    </div>
</x-admin.layouts.app>