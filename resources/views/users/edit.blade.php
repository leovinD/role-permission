@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Password Field (optional) -->
        <div class="form-group">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <!-- Role Selection -->
        <div class="form-group">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md">
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" 
                            {{ $role->name == $user->getRoleNames()->first() ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Permissions Section -->
        <div class="form-group">
            <label class="block text-sm font-medium text-gray-700">Permissions</label>
            <div id="permissions" class="space-y-2">
                @foreach ($user->permissions as $permission)
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" checked class="form-check-input">
                        <label class="form-check-label text-sm">{{ $permission->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Submit and Back Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="btn btn-primary py-2 px-4 rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Update User</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary py-2 px-4 rounded-md text-gray-700 border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500">Back to Users List</a>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // This will fire whenever the role is changed
    document.getElementById('role').addEventListener('change', function() {
        let roleName = this.value;

        // Make an AJAX request to fetch permissions for the selected role
        fetch(`/users/permissions/${roleName}`)
            .then(response => response.json())
            .then(data => {
                let permissionsContainer = document.getElementById('permissions');
                permissionsContainer.innerHTML = '';  // Clear previous permissions
                
                // Dynamically generate permission checkboxes
                data.forEach(permission => {
                    let permissionElement = document.createElement('div');
                    permissionElement.classList.add('form-check');

                    let checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'permissions[]';
                    checkbox.value = permission.name;
                    checkbox.classList.add('form-check-input');
                    
                    let label = document.createElement('label');
                    label.classList.add('form-check-label', 'text-sm');
                    label.textContent = permission.name;

                    permissionElement.appendChild(checkbox);
                    permissionElement.appendChild(label);
                    permissionsContainer.appendChild(permissionElement);
                });
            });
    });
</script>
@endsection
