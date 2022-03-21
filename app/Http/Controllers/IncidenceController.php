<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Incidence;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class IncidenceController extends Controller
{
    public function index() {
        $incidences = Incidence::all();
        $stores = Store::all();
        $users = User::all();
        $agents = Agent::all();

        return view('admin.incidence.index', ['incidences' => $incidences, 'stores' => $stores, 'users' => $users, 'agents' => $agents]);
    }
}
