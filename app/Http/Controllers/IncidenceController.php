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
        $agents = Agent::all();

        return view('admin.incidence.view', ['incidence' => $incidence, 'store' => $store[0], 'user' => $user, 'agent' => $agent, 'order' => $order, 'comments' => $comments, 'agents' => $agents]);
    }

    public function changeAgent($id, Request $request) {
        $incidence = Incidence::find($id);
        $incidence->owner = $request->get('agent');
        $incidence->save();

        return redirect()->to('/incidences/'.$id)->with('success','Agent changed!');
    }

    public function modify($id, Request $request) {
        $incidence = Incidence::find($id);
        $incidence->status = $request->get('status');
        $incidence->closed = $request->get('closed');

        $comments = json_decode($incidence->comments);

        if($request->get('status')!=4) {
            $body_message['message'] = $request->get('message');
            $body_message['owner'] = auth()->user()->name;
            $body_message['type'] = 'user';
    
            $comments[] = $body_message;
    
            $incidence->comments = json_encode($comments);
        }

        $incidence->save();

        return redirect()->to('/incidences');
    }

    public function response($id) {
        
    }
}
