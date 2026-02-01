<x-admin.layouts.app>
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="['Roles' => route('admin.roles.index'), 'Add New' => '#']" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">Add New Role</h2>
    </x-slot>

    <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            
            <div class="mb-8 max-w-xl">
                <x-admin.form.group label="Role Name" name="name" required>
                    <x-admin.form.input name="name" placeholder="e.g. Manager, Editor, Finance" required autofocus />
                </x-admin.form.group>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="font-bold text-gray-900 mb-6 text-lg">Assign Permissions</h3>
                
                {{-- LOGIC GROUPING: Group by kata depan sebelum titik (users, employees, dll) --}}
                @php
                    $groupedPermissions = $permissions->groupBy(function($item) {
                        return explode('.', $item->name)[0]; 
                    });
                @endphp

                <div class="space-y-8">
                    @foreach($groupedPermissions as $group => $perms)
                        <div class="bg-gray-50/50 p-5 rounded-xl border border-gray-100">
                            {{-- Judul Group (Capitalize: users -> Users) --}}
                            <div class="flex items-center gap-3 mb-4">
                                <h4 class="font-bold text-gray-800 capitalize text-md">{{ $group }} Management</h4>
                                <span class="text-xs font-mono text-gray-400 bg-white border border-gray-200 px-2 py-0.5 rounded">
                                    {{ $perms->count() }} permissions
                                </span>
                            </div>

                            {{-- Grid Permission Checkboxes --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($perms as $permission)
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->name }}"
                                               class="rounded border-gray-300 text-primary focus:ring-primary h-5 w-5 transition ease-in-out duration-150">
                                        {{-- Tampilkan label yang lebih bersih (buang nama groupnya) --}}
                                        <span class="text-sm text-gray-600 group-hover:text-gray-900 font-medium select-none capitalize">
                                            {{-- users.create -> Create --}}
                                            {{ explode('.', $permission->name)[1] ?? $permission->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-4">
                <a href="{{ route('admin.roles.index') }}" class="text-sm text-gray-500 font-medium py-2">Cancel</a>
                {{-- Button Label: Create Role --}}
                <x-admin.ui.button>Create Role</x-admin.ui.button>
            </div>
        </form>
    </div>
</x-admin.layouts.app>