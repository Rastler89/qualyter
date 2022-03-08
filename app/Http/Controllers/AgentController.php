<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index() {
        $agents = Agent::all();
        return view('admin.agent.index', ['agents' => $agents]);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:agents',
        ]);

        $agent = new Agent;
        $agent->name = $request->get('name');
        $agent->email = $request->get('email');

        $agent->save();

        return redirect()->route('agents')->with('success','Agent created successfuly');
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $agent = Agent::find($id);
        $agent->name = $request->get('name');
        $agent->email = $request->get('email');

        $agent->save();

        return redirect()->route('agents')->with('success','Agent updated successfuly');
    }

}
