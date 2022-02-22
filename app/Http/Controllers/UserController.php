<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        $roles = Role::all();
        return view('admin.users.index',['users' => $users,'roles' => $roles]);
    }

    public function update(Request $request) {

        $user = User::find($request->get('id'));

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if($request->get('status') == 'on') {
            $status = 1;
        } else {
            $status = 0;
        }
        $user->status = $status;
        $user->save();

        $user->roles()->detach();

        $role = Role::where('slug',$request->get('role'))->first();
        $user->roles()->attach($role);

        return redirect()->route('users');
    }
}
