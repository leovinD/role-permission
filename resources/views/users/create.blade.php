@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Create User</h1>

    <div class="flex flex-col -m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="p-1.5 min-w-full">
                        <label for="name" class="text-sm font-medium text-gray-500 dark:text-neutral-500">Name</label>
                        <input type="text" name="name" id="name" class="form-input w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200" value="{{ old('name') }}" required>
                    </div>

                    <div class="p-1.5 min-w-full">
                        <label for="email" class="text-sm font-medium text-gray-500 dark:text-neutral-500">Email</label>
                        <input type="email" name="email" id="email" class="form-input w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200" value="{{ old('email') }}" required>
                    </div>

                    <div class="p-1.5 min-w-full">
                        <label for="password" class="text-sm font-medium text-gray-500 dark:text-neutral-500">Password</label>
                        <input type="password" name="password" id="password" class="form-input w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200" required>
                    </div>

                    <div class="p-1.5 min-w-full">
                        <label for="role" class="text-sm font-medium text-gray-500 dark:text-neutral-500">Role</label>
                        <select name="role" id="role" class="form-select w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="p-1.5 min-w-full">
                        <label class="text-sm font-medium text-gray-500 dark:text-neutral-500">Permissions</label>
                        <div class="space-y-2">
                            @foreach (Spatie\Permission\Models\Permission::all() as $permission)
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission-{{ $permission->id }}" class="h-5 w-5 text-blue-500 border-gray-300 rounded focus:ring-blue-500 dark:text-blue-500 dark:border-neutral-600">
                                    <label for="permission-{{ $permission->id }}" class="text-sm text-gray-800 dark:text-neutral-200">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <button type="submit" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                            Create User
                        </button>
                        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400">
                            Back to Users List
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
