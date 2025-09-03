<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles')->get();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dibuat!');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $permission->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil diperbarui!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dihapus!');
    }
}
