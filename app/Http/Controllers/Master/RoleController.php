<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Svg\Tag\Rect;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('master.role', compact('roles', 'permissions'));
    }

    public function getbyId($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json($role);
    }

    public function store(Request $request){
        $request->validate([
            'name'          => 'required|string',
            'permissions'   => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        if ($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Role created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string',
            'permissions'   => 'array'
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        };

        return redirect()->back()->with('success', 'Permission updated successfully.');
    }

    public function destroy($id){
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->back()->with('success', 'Role deleted successfully');
    }
}
