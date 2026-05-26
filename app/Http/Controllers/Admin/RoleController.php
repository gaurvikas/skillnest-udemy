<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->paginate(20);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Create role
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        // Attach permissions
        if ($request->permissions) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return to_route('admin.roles.index')->with('status', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = Permission::all();

        return view('admin.roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,'.$role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();

        $role->syncPermissions($permissions);

        return to_route('admin.roles.index')->with('status', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->permissions()->detach();

            $role->delete();

            return to_route('admin.roles.index')->with('status', 'Role deleted successfully!');
        } catch (\Exception $e) {
            return to_route('admin.roles.index')->with('status', 'Failed to delete role.');
        }
    }

    public function storePermission(Request $request)
    {

        $data = $request->all();
        $data['name'] = $data['permission_name'];
        Permission::create($data);

        return response()->json([
            'message' => 'Permission created successfully!',
        ], 200);
    }
}
