<?php

namespace App\Http\Controllers;

use App\Models\Congratulation;
use App\Models\Client;
use App\Models\Agent;
use Illuminate\Http\Request;

class CongratulationController extends Controller
{
    public function index(Request $request) {
        $congratulations = Congratulation::sortable()->paginate(10);

        //poner nombres
        foreach($congratulations as &$congratulation) {
            $client = Client::where('id','=',$congratulation->client)->first();
            $congratulation->client_name = $client->name;
            $agent = Agent::where('id','=',$congratulation->agent)->first();
            $congratulation->agent_name = $agent->name;
        }

        $agents = Agent::all();
        $clients = Client::all();

        return view('admin.congratulations.index', ['congratulations' => $congratulations, 'agents' => $agents, 'clients' => $clients]);
    }

    public function create(Request $request)
    {
        $cong = new Congratulation();

        $cong->agent = $request->agent;
        $cong->client = $request->client;
        $cong->weight = $request->weight;
        $cong->comments = $request->comments;

        $cong->save();

        return redirect()->route('congratulations')->with('success','New congratulation created');

    }

    public function update(Request $request) {
        $cong = Congratulation::find($request->id);

        $cong->agent = $request->agent;
        $cong->client = $request->client;
        $cong->weight = $request->weight;
        $cong->comments = $request->comments;

        $cong->save();

        return redirect()->route('congratulations')->with('success','Congratulation updated');

    }

}
