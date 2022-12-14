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
            $congratulation->client = $client->name;
            $agent = Agent::where('id','=',$congratulation->agent)->first();
            $congratulation->agent = $agent->name;
        }

        return view('admin.congratulations.index', ['congratulations' => $congratulations]);
    }

    public function create(Request $request)
    {
        $cong = new Congratulation();

        $cong->agent = $request->agent;
        $cong->client = $request->client;
        $cong->weight = $request->weight;
        $cong->comments = $request->comments;

        $cong->save();

        return redirect()->route('reports.congratulations')->with('success','New congratulation created');

    }

}
