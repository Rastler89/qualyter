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
}
