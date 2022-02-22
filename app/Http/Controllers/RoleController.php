<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();
        return view('admin.roles.index', ['roles' => $roles]);
    }

    public function new() {
        $permissions = Permission::all();
        return view('admin.roles.profile', ['permissions' => $permissions]);
    }

    public function create(Request $request) {
        $validate = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:roles'
        ]);

        $role = new Role();
        $role->name = $request->get('name');
        $role->slug = $request->get('slug');

        $role->save();

        foreach($request->permission as $permission) {
            $perm = Permission::where('slug',$permission)->first();

            $role->permissions()->attach($perm);
        }

        return redirect()->route('roles');
    }
}
