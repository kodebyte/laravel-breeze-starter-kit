<x-admin.layouts.app title="Edit Role">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Roles' => route('admin.roles.index'), 
                    'Edit Role' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Edit Role: <span class="text-primary">{{ $role->name }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- SINGLE CARD LAYOUT --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 space-y-8">
                
                {{-- SECTION 1: ROLE IDENTITY --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                            <x-admin.icon.shield class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Role Identity</h3>
                            <p class="text-xs text-gray-500">Update the name of the role.</p>
                        </div>
                    </div>

                    <div class="max-w-xl">
                        <x-admin.form.group label="Role Name" name="name" required>
                            <x-admin.form.input name="name" :value="old('name', $role->name)" required />
                        </x-admin.form.group>
                    </div>
                </div>

                {{-- SEPARATOR --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 2: PERMISSIONS --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            <x-admin.icon.key class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Access Permissions</h3>
                            <p class="text-xs text-gray-500">Manage capabilities for this role.</p>
                        </div>
                    </div>

                    @php
                        $groupedPermissions = $permissions->groupBy(function($item) {
                            return explode('.', $item->name)[0]; 
                        });
                    @endphp

                    <div class="space-y-6">
                        @foreach($groupedPermissions as $group => $perms)
                            <div class="bg-gray-50/50 p-5 rounded-xl border border-gray-100 hover:border-purple-200 transition-colors">
                                
                                <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-2">
                                    <h4 class="font-bold text-gray-800 capitalize text-sm flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                        {{ $group }} Management
                                    </h4>
                                    <span class="text-[10px] font-mono text-gray-400 bg-white border border-gray-200 px-1.5 py-0.5 rounded">
                                        {{ $perms->count() }} items
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    @foreach($perms as $permission)
                                        @php
                                            $isChecked = $role->hasPermissionTo($permission->name);
                                        @endphp
                                        
                                        {{-- Interactive Label: Kalo dicek, background jadi putih --}}
                                        <label class="flex items-center space-x-2.5 p-2 rounded-lg cursor-pointer transition-all duration-200 {{ $isChecked ? 'bg-white shadow-sm border border-gray-200' : 'hover:bg-gray-200/50 border border-transparent' }}">
                                            <div class="relative flex items-center">
                                                <input type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->name }}"
                                                       class="peer h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500 cursor-pointer"
                                                       {{ $isChecked ? 'checked' : '' }}>
                                            </div>
                                            <span class="text-sm font-medium select-none capitalize transition-colors {{ $isChecked ? 'text-purple-700' : 'text-gray-600' }}">
                                                {{ explode('.', $permission->name)[1] ?? $permission->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- FOOTER CARD --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.roles.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <x-admin.ui.button type="submit">
                    Update Role
                </x-admin.ui.button>
            </div>
            
        </div>
    </form>
</x-admin.layouts.app>