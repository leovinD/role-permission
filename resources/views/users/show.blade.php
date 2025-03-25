@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-semibold mb-6">User Details: {{ $user->name }}</h1>

    <!-- Email Display -->
    <div class="mb-4">
        <strong class="text-sm font-medium text-gray-700">Email:</strong>
        <p class="mt-1 text-lg text-gray-800">{{ $user->email }}</p>
    </div>

    <!-- Roles Display -->
    <div class="mb-4">
        <strong class="text-sm font-medium text-gray-700">Roles:</strong>
        <div class="mt-2">
            @forelse ($user->roles as $role)
                <span class="inline-block bg-blue-600 text-white text-xs py-1 px-3 rounded-full mr-2">{{ $role->name }}</span>
            @empty
                <span class="inline-block bg-yellow-400 text-gray-700 text-xs py-1 px-3 rounded-full">No roles assigned</span>
            @endforelse
        </div>
    </div>

    <!-- Permissions Display -->
    <div class="mb-4">
        <strong class="text-sm font-medium text-gray-700">Permissions:</strong>
        <div class="mt-2">
            @forelse ($user->permissions as $permission)
                <span class="inline-block bg-gray-600 text-white text-xs py-1 px-3 rounded-full mr-2">{{ $permission->name }}</span>
            @empty
                <span class="inline-block bg-yellow-400 text-gray-700 text-xs py-1 px-3 rounded-full">No permissions assigned</span>
            @endforelse
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md px-4 py-2 border border-transparent">Back to Users List</a>
    </div>
</div>
@endsection
