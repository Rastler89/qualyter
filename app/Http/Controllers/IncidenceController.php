<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Incidence;
use App\Models\Store;
use App\Models\User;
use App\Models\Task;
use App\Models\Log;
use Illuminate\Http\Request;
use Mail;
use App\Mail\NotifyMail;

class IncidenceController extends Controller
{
    public function index(Request $request) {
        $client = $request->query('client');
        $store = $request->query('store');
        $incidences = Incidence::query();

        if(!empty($store) && $store != '') {
            $id = [];
            $stores = Store::where('name','LIKE','%'.$store.'%')->get();
            foreach($stores as $s) {
                $id[] = $s->code;
            }
            $incidences->whereIn('store',$id);
        }

        if(!empty($client) && $client != '') {
            $id = [];
            $clients = Client::where('name','LIKE','%'.$client.'%')->get();
            foreach($clients as $c) {
                $id[] = $c->id;
            }
            $incidences->whereIn('client',$id);
        }

        $incidences = $incidences->sortable()->paginate(10);

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
        $validated = $request->validate([
            'message' => 'required'
        ]);
        $incidence = Incidence::find($id);
        $old_incidence = Incidence::find($id);
        
        $incidence->status = $request->get('status');
        
        if($incidence->status != null) {
            $incidence->status = $request->get('status');
        }

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

        if($old_incidence->status != $incidence->status) {
            $log->saveLog($old_incidence,$incidence,'i');
        }

        $ot = json_decode($incidence->order);
        $messages = json_decode($incidence->comments);
        $agent = Agent::find($incidence->owner);

        $body = [
            'responsable' => $incidence->responsable,
            'owner' => $agent,
            'impact' => $incidence->impact,
            'token' => $incidence->token,
            'ot' => $ot,
            'id' => $incidence->id,
            'comment' => $messages[count($messages)-1]->message,
            'new' => false
        ];

        if(env('APP_NAME')=='QualyterTEST') {
            Mail::to('test@optimaretail.es')->send(new NotifyMail($body));
        } else {
            Mail::to($agent['email'])->send(new NotifyMail($body));
        }

        return redirect()->to('/incidences')->with('success','Notify agent in this moment');
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
        $old_incidence = Incidence::find($id);

        $incidence->status = 1;
        $incidence->closed = $request->get('closed');

        $comments = json_decode($incidence->comments);

        $body_message['message'] = $request->get('message');
        $body_message['owner'] = $request->get('agent');
        $body_message['type'] = 'agent';

        $comments[] = $body_message;

        $incidence->comments = json_encode($comments);

        $incidence->save();

        $log = new Log();
        $log->table = 'a';
        $log->row_id = $id;
        $log->old = $old_incidence->status;
        $log->new = 1;
        $log->created = date('Y-m-d H:i');
        $log->save();
        $ot = json_decode($incidence->order);
        $messages = json_decode($incidence->comments);
        $agent = Agent::find($incidence->owner);

        $user = User::find($incidence->responsable);

        $body = [
            'responsable' => $incidence->responsable,
            'owner' => $agent,
            'impact' => $incidence->impact,
            'token' => $incidence->token,
            'ot' => $ot,
            'id' => $incidence->id,
            'comment' => $messages[count($messages)-1]->message,
            'new' => false
        ];

        if(env('APP_NAME')=='QualyterTEST') {
            Mail::to('test@optimaretail.es')->send(new NotifyMail($body));
        } else {
            Mail::to($user['email'])->send(new NotifyMail($body));
        }

        return view('public.thanksAgents');
    }

    public function resend($id) {
        $incidence = Incidence::find($id);
        
        $ot = json_decode($incidence->order);
        $messages = json_decode($incidence->comments);
        $agent = Agent::find($incidence->owner);

        $body = [
            'responsable' => $incidence->responsable,
            'owner' => $agent,
            'impact' => $incidence->impact,
            'token' => $incidence->token,
            'ot' => $ot,
            'id' => $incidence->id,
            'comment' => $messages[0]->message,
            'new' => true
        ];

        if(env('APP_NAME')=='QualyterTEST') {
            Mail::to('test@optimaretail.es')->send(new NotifyMail($body));
        } else {
            Mail::to($agent['email'])->send(new NotifyMail($body));
        }

        return redirect()->to('/incidences/'.$id)->with('success','Incidence sended!');
    }
}
