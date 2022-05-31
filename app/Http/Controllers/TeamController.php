<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $manager = User::whereHas(
            'roles', function($q){
                $q->where('name', 'manager');
            }
        )->get();
        return view('admin.teams.index',['teams'=>$teams, 'managers' => $manager]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'url' => 'required',
            'manager' => 'required'
        ]);

        $team = new Team;
        $team->name = $request->get('name');
        $team->url = $request->get('url');
        $manager = explode(' ',$request->get('manager'));
        $team->manager = $manager[0];

        $team->save();

        return redirect()->route('team.index')->with('success','Team created ');
    }

    public function update(Request $request, $id) {
        $team = Team::find($id);

        $team->name = $request->get('name');
        $team->url = $request->get('url');
        $manager = explode(' ',$request->get('manager'));
        $team->manager = $manager[0];

        $team->save();

        return redirect()->route('team.index')->with('success','Team updated');
    }

}
