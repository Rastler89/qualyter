<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Answer;
use App\Models\Incidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        return redirect()->route('users')->with('success','User updated successfuly!');
    }

    public function new() {
        $roles = Role::all();
        return view('admin.users.create', ['roles' => $roles]);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users', 
            'password' => 'required|between:8,255|confirmed',
        ]);

        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));

        $user->save();

        if($request->get('role') != '---') {
            $role = Role::where('slug',$request->get('role'))->first();
            $user->roles()->attach($role);
        }

        return redirect()->route('users')->with('success','User added successfuly!');
    }

    public function getProfile() {
        $data = [];

        $user = User::find(auth()->user()->id);
        $data['day_answer'] = count(Answer::where('status','=',2)->where('user','=',auth()->user()->id)->where('updated_at','>=',date('Y-m-d 00:00:01'))->get());
        $data['day_open_incidence'] = count(Incidence::where('responsable','=',auth()->user()->id)->where('created_at','>=',date('Y-m-d 00:00:01'))->get());
        $data['day_close_incidence'] = count(Incidence::where('responsable','=',auth()->user()->id)->where('updated_at','>=',date('Y-m-d 00:00:01'))->where('status','=',4)->get());
        $data['total_answer'] = count(Answer::where('status','=',2)->where('user','=',auth()->user()->id)->get());
        $data['total_open_incidence'] = count(Incidence::where('responsable','=',auth()->user()->id)->get());
        $data['total_close_incidence'] = count(Incidence::where('responsable','=',auth()->user()->id)->where('status','=',4)->get());

        return view('admin.users.profile', ['user' => $user, 'data' => $data]);
    }

    public function saveName(Request $request) {
        $validated = $request->validate([
            'name' => 'required|between:1,255'
        ]);

        $user = User::find(auth()->user()->id);

        $user->name = $request->get('name');
        $user->token = $request->get('token');
        $user->phone = $request->get('phone');
        $user->save();

        return redirect()->route('profile')->with('success','Update your name!');
    }

    public function savePassword(Request $request) {
        $validated = $request->validate([
            'password' => 'required|between:8,255|confirmed',
        ]);

        $user = User::find(auth()->user()->id);

        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect()->route('profile')->with('success','Password changed');
    }
}
