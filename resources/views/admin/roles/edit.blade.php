<x-admin.layouts.app>
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="['Roles' => route('admin.roles.index'), 'Edit Role' => '#']" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            Edit Role: <span class="text-primary">{{ $role->name }}</span>
        </h2>
    </x-slot>

    <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm">
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-8 max-w-xl">
                <x-admin.form.group label="Role Name" name="name" required>
                    <x-admin.form.input name="name" :value="old('name', $role->name)" required />
                </x-admin.form.group>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="font-bold text-gray-900 mb-6 text-lg">Manage Permissions</h3>
                
                @php
                    $groupedPermissions = $permissions->groupBy(function($item) {
                        return explode('.', $item->name)[0]; 
                    });
                @endphp

                <div class="space-y-8">
                    @foreach($groupedPermissions as $group => $perms)
                        <div class="bg-gray-50/50 p-5 rounded-xl border border-gray-100">
                            <div class="flex items-center gap-3 mb-4">
                                <h4 class="font-bold text-gray-800 capitalize text-md">{{ $group }} Management</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($perms as $permission)
                                    @php
                                        $isChecked = $role->hasPermissionTo($permission->name);
                                    @endphp
                                    <label class="flex items-center space-x-3 p-2 rounded-lg cursor-pointer transition {{ $isChecked ? 'bg-white shadow-sm border border-gray-200' : 'hover:bg-gray-100' }}">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->name }}"
                                               class="rounded border-gray-300 text-primary focus:ring-primary h-5 w-5"
                                               {{ $isChecked ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-700 font-medium select-none capitalize">
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
                {{-- Button Label: Update Role --}}
                <x-admin.ui.button>Update Role</x-admin.ui.button>
            </div>
        </form>
    </div>
</x-admin.layouts.app>