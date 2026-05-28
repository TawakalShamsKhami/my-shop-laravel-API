<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json(Role::with('permissions')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
        ]);

        $role = Role::create($data);

        return response()->json($role, 201);
    }

    public function assignUser(Role $role, User $user)
    {
        if (! $role->is_active) {
            return response()->json(['message' => 'Role is inactive'], 403);
        }

        if (! $user->is_active) {
            return response()->json(['message' => 'User is inactive'], 403);
        }

        $role->users()->syncWithoutDetaching([$user->id => ['is_active' => true]]);

        return response()->json([
            'message' => 'Role assigned to user',
            'role' => $role->name,
            'user' => $user->email,
        ]);
    }

    public function attachPermission(Role $role, Permission $permission)
    {
        if (! $role->is_active) {
            return response()->json(['message' => 'Role is inactive'], 403);
        }

        if (! $permission->is_active) {
            return response()->json(['message' => 'Permission is inactive'], 403);
        }

        $role->permissions()->syncWithoutDetaching([$permission->id => ['is_active' => true]]);

        return response()->json([
            'message' => 'Permission attached to role',
            'role' => $role->name,
            'permission' => $permission->name,
        ]);
    }
}
