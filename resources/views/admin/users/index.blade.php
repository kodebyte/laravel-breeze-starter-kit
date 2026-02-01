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
            
            {{-- SEARCH SECTION (Pakai Component Search) --}}
            <div class="p-4 border-b border-gray-100 flex justify-end">
                <x-admin.form.search placeholder="Search name or email..." />
            </div>

            {{-- TABLE SECTION (Pakai Component Table) --}}
            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th-sortable name="name" label="Full Name" />
                    <x-admin.table.th-sortable name="email" label="Email Address" />
                    <x-admin.table.th label="Role" />
                    <x-admin.table.th-sortable name="created_at" label="Joined Date" />
                    <x-admin.table.th class="relative"><span class="sr-only">Actions</span></x-admin.table.th>
                </x-admin.table.thead>

                <x-admin.table.tbody>
                    @forelse($users as $user)
                        <x-admin.table.tr>
                            
                            {{-- 1. AVATAR & NAME --}}
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
                                            Staff ID: #{{ $user->id }}
                                        </div>
                                    </div>
                                </div>
                            </x-admin.table.td>
                            
                            {{-- 2. EMAIL --}}
                            <x-admin.table.td>{{ $user->email }}</x-admin.table.td>

                            {{-- 3. ROLE (Pakai Badge) --}}
                            <x-admin.table.td>
                                @foreach($user->roles as $role)
                                    <x-admin.ui.badge 
                                        :label="$role->name" 
                                        :color="$role->name === 'Super Admin' ? 'primary' : 'info'" 
                                    />
                                @endforeach
                            </x-admin.table.td>

                            {{-- 4. JOINED DATE --}}
                            <x-admin.table.td>{{ $user->created_at->format('d M Y') }}</x-admin.table.td>

                            {{-- 5. ACTIONS (Edit & Delete) --}}
                            <x-admin.table.td class="text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    {{-- Tombol Edit --}}
                                    @can('users.update')
                                        <x-admin.ui.action-edit :href="route('admin.users.edit', $user)" />
                                    @endcan
                                    
                                    @can('users.delete')
                                        {{-- Tombol Delete (Gak perlu nulis form manual lagi!) --}}
                                        <x-admin.ui.action-delete :action="route('admin.users.destroy', $user)" />
                                    @endcan
                                </div>
                            </x-admin.table.td>

                        </x-admin.table.tr>
                    @empty
                        <x-admin.table.empty 
                            colspan="5" 
                            :create-route="auth()->user()->can('users.create') ? route('admin.users.create') : null" 
                        />
                    @endforelse
                </x-admin.table.tbody>
            </x-admin.table>

            {{-- FOOTER SECTION (Pakai Component Footer) --}}
            <x-admin.table.footer :data="$users" />
        </div>
    </div>
</x-admin.layouts.app>