@props(['action'])

<form action="{{ $action }}" ... >
    @csrf
    @method('DELETE')
    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Delete">
        <x-admin.icon.trash />
    </button>
</form>