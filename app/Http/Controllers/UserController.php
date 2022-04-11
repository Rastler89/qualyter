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

        
        if($request->get('role') != '---') {
            $role = Role::where('slug',$request->get('role'))->first();
            $user->roles()->attach($role);
        }

        return redirect()->route('users')->with('success','User updated successfuly!');;
    }

    public function new() {
        $roles = Role::all();
        return view('admin.users.create', ['roles' => $roles]);
    }

    public function create(Request $request) {
        print_r($request->get('password'));
        echo"<hr>";
        print_r($request->get('password-confirmation'));
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users', 
            'password' => 'required|between:8,255|confirmed',
        ]);

        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');

        $user->save();

        if($request->get('role') != '---') {
            $role = Role::where('slug',$request->get('role'))->first();
            $user->roles()->attach($role);
        }

        return redirect()->route('users')->with('success','User added successfuly!');;
    }

    public function getProfile() {
        $user = User::find(auth()->user()->id);

        return view('admin.users.profile', ['user' => $user]);
    }
}
