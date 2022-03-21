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

    public function view($id) {
        $incidence = Incidence::find($id);
        $store = Store::where('code','=',$incidence->store)->get();
        $user = User::find($incidence->responsable);
        $agent = Agent::find($incidence->owner);
        $order = json_decode($incidence->order);
        $comments = json_decode($incidence->comments);

        return view('admin.incidence.view', ['incidence' => $incidence, 'store' => $store[0], 'user' => $user, 'agent' => $agent, 'order' => $order, 'comments' => $comments]);
    }
}
