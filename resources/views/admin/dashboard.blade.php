<x-admin.layouts.app title="Dashboard">
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="['Dashboard' => '#']" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            Dashboard Overview
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- 1. STATS CARDS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Total Employees --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <x-admin.icon.briefcase class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Employees</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_employees'] }}</h3>
                </div>
            </div>

            {{-- Active Staff --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Active Staff</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['active_staff'] }}</h3>
                </div>
            </div>

            {{-- Total Clients/Users --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Clients</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</h3>
                </div>
            </div>

            {{-- Total Roles --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                    <x-admin.icon.shield class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">System Roles</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_roles'] }}</h3>
                </div>
            </div>

        </div>

        {{-- 2. RECENT EMPLOYEES TABLE --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900">Recently Added Employees</h3>
                @can('employees.view')
                    <a href="{{ route('admin.employees.index') }}" class="text-sm text-primary font-bold hover:underline">View All</a>
                @endcan
            </div>
            
            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th label="Employee" />
                    <x-admin.table.th label="Role" />
                    <x-admin.table.th label="Status" />
                    <x-admin.table.th label="Joined At" />
                </x-admin.table.thead>
                <x-admin.table.tbody>
                    @foreach($recentEmployees as $emp)
                        <x-admin.table.tr>
                            <x-admin.table.td>
                                <div class="font-bold text-gray-900">{{ $emp->name }}</div>
                                <div class="text-xs text-gray-400">{{ $emp->email }}</div>
                            </x-admin.table.td>
                            <x-admin.table.td>
                                <x-admin.ui.badge :label="$emp->roles->first()->name ?? '-'" color="gray" />
                            </x-admin.table.td>
                            <x-admin.table.td>
                                <x-admin.ui.badge 
                                    :label="$emp->status->label()" 
                                    :color="$emp->status->value === 'active' ? 'emerald' : 'red'" 
                                />
                            </x-admin.table.td>
                            <x-admin.table.td class="text-gray-500">
                                {{ $emp->created_at->diffForHumans() }}
                            </x-admin.table.td>
                        </x-admin.table.tr>
                    @endforeach
                </x-admin.table.tbody>
            </x-admin.table>
        </div>
    </div>
</x-admin.layouts.app>