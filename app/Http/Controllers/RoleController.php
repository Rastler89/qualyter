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
        return view('admin.roles.profile', ['permissions' => $permissions, 'role' => null, 'role_permission' => null]);
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

    public function edit($id) {
        $permissions = Permission::all();
        $role = Role::find($id);
        $role_permission = Role::find($id)->permissions;
        //echo"<pre>";var_dump($role);echo"</pre>";die();
        return view('admin.roles.profile', ['permissions' => $permissions, 'role' => $role, 'role_permission' => $role_permission]);
    }

    public function update($id, Request $request) {
        $validate = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:roles'
        ]);

        $role = Role::find($id); 
        $role->name = $request->get('name');
        $role->slug = $request->get('slug');
        $role->save();

        $role->permissions()->detach();

        foreach($request->permission as $permission) {
            $perm = Permission::where('slug',$permission)->first();

            $role->permissions()->attach($perm);
        }

        return redirect()->route('roles');
    }

    public function delete($id) {
        $role = Role::find($id);
        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('roles');
    }
}
