<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Get users with their roles and permissions
        $users = User::with('roles', 'permissions')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Get all roles to display in the create form
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // Validate the data
        $validator->validate();

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the role to the user
        $user->assignRole($request->role);

        // Assign permissions if provided
        if ($request->permissions) {
            $user->givePermissionTo($request->permissions);
        }

        // Redirect with a success message
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the details of the specified user.
     */
    public function show($id)
    {
        // Retrieve the user by their ID, including their roles and permissions
        $user = User::with('roles', 'permissions')->findOrFail($id);

        // Return the view and pass the user data
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Get all roles and the user's permissions
        $roles = Role::all();
        $userPermissions = $user->permissions->pluck('name')->toArray(); // Get the user's permissions
        return view('users.edit', compact('user', 'roles', 'userPermissions'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        // Validate incoming data
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // Update user details
        $user->update($data);

        // Sync the role
        $user->syncRoles([$data['role']]);

        // Sync the permissions if provided
        if (!empty($data['permissions'])) {
            $user->syncPermissions($data['permissions']);
        }

        // Redirect with success message
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Get permissions for a specific role.
     */
    public function getPermissionsForRole($roleName)
    {
        // Find the role by name
        $role = Role::findByName($roleName);

        // Get the permissions associated with the role
        $permissions = $role->permissions;

        // Return permissions as a JSON response
        return response()->json($permissions);
    }
}
