<x-admin.layouts.app title="Role Management">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Roles' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Role Management
                </h2>
            </div>

            @can('roles.create')
                <x-admin.ui.link-button href="{{ route('admin.roles.create') }}">
                    <x-admin.icon.plus class="w-4 h-4 mr-2" />
                    Create New Role
                </x-admin.ui.link-button>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
            
            <div class="p-4 border-b border-gray-100 flex justify-end">
                <x-admin.form.search placeholder="Search roles..." />
            </div>

            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th-sortable name="name" label="Role Name" />
                    <x-admin.table.th label="Permissions" />
                    <x-admin.table.th label="Users Assigned" />
                    <x-admin.table.th-sortable name="created_at" label="Created At" />
                    <x-admin.table.th class="relative"><span class="sr-only">Actions</span></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($roles as $role)
                        <x-admin.table.tr>
                            
                            {{-- 1. NAME --}}
                            <x-admin.table.td>
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                        <x-admin.icon.shield class="w-5 h-5" />
                                    </div>
                                    <span class="font-bold text-gray-900">{{ $role->name }}</span>
                                </div>
                            </x-admin.table.td>

                            {{-- 2. PERMISSIONS COUNT --}}
                            <x-admin.table.td>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $role->permissions_count }} Access
                                </span>
                            </x-admin.table.td>

                            {{-- 3. USERS COUNT --}}
                            <x-admin.table.td>
                                <div class="flex -space-x-2 overflow-hidden">
                                    @foreach($role->users->take(3) as $user)
                                        <x-admin.ui.avatar :name="$user->name" class="inline-block h-6 w-6 ring-2 ring-white" />
                                    @endforeach
                                    @if($role->users_count > 3)
                                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full ring-2 ring-white bg-gray-100 text-[10px] font-bold text-gray-500">
                                            +{{ $role->users_count - 3 }}
                                        </span>
                                    @endif
                                </div>
                            </x-admin.table.td>

                            {{-- 4. DATE --}}
                            <x-admin.table.td>{{ $role->created_at->format('d M Y') }}</x-admin.table.td>

                            {{-- 5. ACTIONS --}}
                            <x-admin.table.td class="text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    
                                    {{-- LOGIC: Cek Nama Role --}}
                                    @if($role->name === 'Super Admin')
                                        
                                        {{-- Kalau Super Admin: KUNCI --}}
                                        <span class="text-xs text-gray-400 font-bold flex items-center gap-1 border border-gray-200 bg-gray-50 px-2 py-1 rounded select-none" title="System Role cannot be modified">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            </svg>
                                            System
                                        </span>

                                    @else
                                        
                                        {{-- Kalau Role Biasa: Show Edit & Delete --}}
                                        @can('roles.update')
                                            <x-admin.ui.action-edit :href="route('admin.roles.edit', $role)" />
                                        @endcan
                                        
                                        @can('roles.delete')
                                            <x-admin.ui.action-delete :action="route('admin.roles.destroy', $role)" />
                                        @endcan

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
    </div>
</x-admin.layouts.app>