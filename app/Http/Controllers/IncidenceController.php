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

    public function response($id, Request $request) {
        $incidence = Incidence::find($id);

        if($incidence->token != $request->get('code')) {
            abort(403, 'Unauthorized action.');
        }

        $store = Store::where('code','=',$incidence->store)->get();
        $user = User::find($incidence->responsable);
        $agent = Agent::find($incidence->owner);
        $order = json_decode($incidence->order);
        $comments = json_decode($incidence->comments);
        $agents = Agent::all();

        return view('public.agent', ['incidence' => $incidence, 'store' => $store[0], 'user' => $user, 'agent' => $agent, 'order' => $order, 'comments' => $comments, 'agents' => $agents]);
    }

    public function update($id, Request $request) {
        $incidence = Incidence::find($id);
        $incidence->status = 1;
        $incidence->closed = $request->get('closed');

        $comments = json_decode($incidence->comments);

        $body_message['message'] = $request->get('message');
        $body_message['owner'] = $request->get('agent');
        $body_message['type'] = 'agent';

        $comments[] = $body_message;

        $incidence->comments = json_encode($comments);

        $incidence->save();

        return 'ok';
    }
}
