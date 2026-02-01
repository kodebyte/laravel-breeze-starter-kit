<x-admin.layouts.app>
    
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Employees' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">Employee Management</h2>
            </div>

            @can('employees.create')
                <x-admin.ui.link-button href="{{ route('admin.employees.create') }}">
                    <x-admin.icon.plus class="w-4 h-4 mr-2" /> Add New Employee
                </x-admin.ui.link-button>
            @endcan
        </div>
    </x-slot>

    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex justify-end">
            <x-admin.form.search placeholder="Search name, email, or ID..." />
        </div>

        <x-admin.table>
            <x-admin.table.thead>
                <x-admin.table.th-sortable name="identifier" label="ID" />
                <x-admin.table.th-sortable name="name" label="Name" />
                <x-admin.table.th label="Role" />
                <x-admin.table.th-sortable name="email" label="Email" />
                <x-admin.table.th />
            </x-admin.table.thead>

            <x-admin.table.tbody>
                @forelse($employees as $emp)
                    <x-admin.table.tr>
                        <x-admin.table.td class="font-mono text-xs text-gray-400">{{ $emp->identifier }}</x-admin.table.td>
                        <x-admin.table.td>
                            <div class="flex items-center">
                                <x-admin.ui.avatar :name="$emp->name" class="w-8 h-8 mr-3" />
                                <span class="font-bold text-gray-900">{{ $emp->name }}</span>
                            </div>
                        </x-admin.table.td>
                        <x-admin.table.td>
                            @foreach($emp->roles as $role)
                                <x-admin.ui.badge :label="$role->name" color="info" />
                            @endforeach
                        </x-admin.table.td>
                        <x-admin.table.td>{{ $emp->email }}</x-admin.table.td>
                        <x-admin.table.td class="text-right">
                            <div class="flex justify-end gap-3">
                                @can('employees.update')
                                    <x-admin.ui.action-edit :href="route('admin.employees.edit', $emp)" />
                                @endcan

                                @can('employees.delete')
                                    <x-admin.ui.action-delete :action="route('admin.employees.destroy', $emp)" />
                                @endcan
                            </div>
                        </x-admin.table.td>
                    </x-admin.table.tr>
                @empty
                    <x-admin.table.empty 
                        colspan="5" 
                        :create-route="auth()->user()->can('employees.create') ? route('admin.employees.create') : null" 
                    />
                @endforelse
            </x-admin.table.tbody>
        </x-admin.table>
        
        <x-admin.table.footer :data="$employees" />
    </div>
    
</x-admin.layouts.app>