<x-admin.layouts.app title="Employee Management">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Employees' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Employee Management
                </h2>
            </div>

            @can('employees.create')
                <x-admin.ui.link-button href="{{ route('admin.employees.create') }}">
                    <x-admin.icon.plus class="w-4 h-4 mr-2" />
                    Add New Employee
                </x-admin.ui.link-button>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            {{-- SEARCH SECTION --}}
            <div class="p-4 border-b border-gray-100 flex justify-end">
                <x-admin.form.search placeholder="Search name, ID, or email..." />
            </div>

            {{-- TABLE SECTION --}}
            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th-sortable name="identifier" label="ID" />
                    <x-admin.table.th-sortable name="name" label="Employee Name" />
                    <x-admin.table.th label="Role" />
                    <x-admin.table.th label="Status" />
                    <x-admin.table.th-sortable name="created_at" label="Joined Date" />
                    <x-admin.table.th class="relative"><span class="sr-only">Actions</span></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($employees as $employee)
                        <x-admin.table.tr>
                            
                            {{-- 1. ID --}}
                            <x-admin.table.td>
                                <span class="font-mono text-xs font-bold bg-gray-50 px-2 py-1 rounded border border-gray-200">
                                    {{ $employee->identifier }}
                                </span>
                            </x-admin.table.td>

                            {{-- 2. NAME --}}
                            <x-admin.table.td>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9">
                                        <x-admin.ui.avatar :name="$employee->name" class="ring-2 ring-white" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900 group-hover:text-primary transition-colors">
                                            {{ $employee->name }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $employee->email }}
                                        </div>
                                    </div>
                                </div>
                            </x-admin.table.td>

                            {{-- 3. ROLE --}}
                            <x-admin.table.td>
                                @foreach($employee->roles as $role)
                                    <x-admin.ui.badge :label="$role->name" color="info" />
                                @endforeach
                            </x-admin.table.td>

                            {{-- 4. STATUS --}}
                            <x-admin.table.td>
                                <x-admin.ui.badge 
                                    :label="$employee->status->label()" 
                                    :color="$employee->status->value === 'active' ? 'success' : 'danger'" 
                                />
                            </x-admin.table.td>

                            {{-- 5. DATE --}}
                            <x-admin.table.td>{{ $employee->created_at->format('d M Y') }}</x-admin.table.td>

                            {{-- 6. ACTIONS --}}
                            <x-admin.table.td class="text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    @can('employees.update')
                                        <x-admin.ui.action-edit :href="route('admin.employees.edit', $employee)" />
                                    @endcan
                                    
                                    @can('employees.delete')
                                        <x-admin.ui.action-delete :action="route('admin.employees.destroy', $employee)" />
                                    @endcan
                                </div>
                            </x-admin.table.td>

                        </x-admin.table.tr>
                    @empty
                        <x-admin.table.empty 
                            colspan="6" 
                            :create-route="auth()->user()->can('employees.create') ? route('admin.employees.create') : null" 
                        />
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>

            <x-admin.table.footer :data="$employees" />
        </div>
    </div>
</x-admin.layouts.app>