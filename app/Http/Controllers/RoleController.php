<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->attach($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat!');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui!');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus!');
    }
}
