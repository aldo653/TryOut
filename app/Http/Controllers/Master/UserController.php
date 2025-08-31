<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('roles')->get(); // Fetch all users with their roles
        $role = Role::all(); // Fetch all roles
        return view('master.user', compact('user', 'role')); // Return the user view with the users
    }

    public function getbyId($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip_nim' => 'required|string|max:255|unique:users',
            'gender' => 'required|string',
            'password' => 'required|string|min:8',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'nip_nim' => $request->nip_nim,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
        ]);

        // Assign roles if provided
        if ($request->role) {
            $user->syncRoles($request->role);
        }

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip_nim' => 'required|string|max:255|unique:users,nip_nim,' . $user->id,
            'gender' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required',
        ]);

        $user->name = $request->nama;
        $user->nip_nim = $request->nip_nim;
        $user->gender = $request->gender;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Update roles if provided
        if ($request->role) {
            $user->syncRoles($request->role);
        }

        return redirect()->back()->with('success', 'User updated successfully.');
    }
}
