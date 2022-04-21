<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Answer;
use App\Models\Client;
use App\Models\Store;
use App\Models\Task;
use App\Models\Incidence;
use App\Http\Controllers\AuditionController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use App\Mail\NotifyMail;

class AnswerController extends Controller
{
    public function index(Request $request) {

        $client = $request->query('client');
        $store = $request->query('store');
        $work = $request->query('workorder');

        $pre_answers = Answer::where('status','!=',2);

        if(!empty($store) && $store != '') {
            $id = [];
            $stores = Store::where('name','LIKE','%'.$store.'%')->get();
            foreach($stores as $s) {
                $id[] = $s->code;
            }
            $pre_answers->whereIn('store',$id);
        }

        if(!empty($client) && $client != '') {
            $id = [];
            $clients = Client::where('name','LIKE','%'.$client.'%')->get();
            foreach($clients as $c) {
                $id[] = $c->id;
            }
            $pre_answers->whereIn('client',$id);
        }

        if(!empty($work) && $work != '') {
            $id=[];
            $tasks = Task::where('code','LIKE','%'.$work.'%')->get();
            foreach($tasks as $t) {
                $id[] = $t->answer_id;
            }
            $pre_answers->whereIn('id',$id);
        }

        $answers = $pre_answers->sortable()->paginate(10);
        $stores = Store::all();
        $clients = Client::all();

        $id = auth()->user()->id;

        return view('admin.answer.index',['answers' => $answers, 'stores' => $stores, 'clients' => $clients, 'id' => $id, 'filterStore' => $store, 'filterClient' => $client, 'filterWO' => $work]);
    }

    public function view($id) {
        $log = new AuditionController();
        $answer = Answer::find($id);
        $old_answer = $answer;

        //Add user and modify status
        $answer->status = 1;
        $answer->user = auth()->user()->id;
        $answer->save();

        if($old_answer->status != $answer->status) {
            $log->saveLog($old_answer,$answer,'a');
        }

        $store = Store::where('code','=',$answer->store)->where('client','=',$answer->client)->first();
        $agents = Agent::all();
        $tasks = Task::where('answer_id','=',$answer->id)->get();
        foreach($tasks as $task) {
            $owners[] = $task->owner;
        }

        $owners = Agent::find($owners);
        return view('admin.answer.view', ['answer' => $answer, 'store' => $store, 'tasks' => $tasks, 'agents' => $agents, 'owners' => $owners]);
    }

    public function response(Request $request, $id) {
        $body = [];
        $body['valoration'][0] = $request->get('valoration1');
        $body['valoration'][1] = $request->get('valoration2');
        $body['valoration'][2] = $request->get('valoration3');
        $body['valoration'][3] = $request->get('valoration4');
        $body['comment'][0] = $request->get('comment1');
        $body['comment'][1] = $request->get('comment2');
        $body['comment'][2] = $request->get('comment3');
        $body['comment'][3] = $request->get('comment4');

        $answer = Answer::find($id);
        $old_answer = $answer;

        $answer->status = 2;
        $answer->answer = json_encode($body,true);

        $answer->save();

        if($old_answer->status != $answer->status) {
            $log->saveLog($old_answer,$answer,'a');
        }

        $body = null;

        if($request['responsable'][0] != '--') {

            foreach($request->get('responsable') as $index => $responsable ) {
                $body[0]['message'] = $request['incidence'][$index];
                $body[0]['owner'] = auth()->user()->name;
                $body[0]['type'] = 'user';
    
                $task = explode('-',$request['responsable'][$index]);
    
                $ot = Task::where('code','=',$task[1])->first();
    
                $incidence = new Incidence();
    
                $incidence->responsable = auth()->user()->id; 
                $incidence->owner = $task[0];
                $incidence->impact = $request['impact'][$index];
                $incidence->status = 0;
                $incidence->comments = json_encode($body);
                $incidence->client = $answer->client;
                $incidence->store = $answer->store;
                $incidence->order = json_encode($ot);
                $incidence->token = Str::random(8);
    
                $incidence->save();

                $agent = Agent::find($task[0]);
                $body = [];
                $body = [
                    'responsable' => auth()->user()->name,
                    'owner' => $agent,
                    'impact' => $request['impact'][$index],
                    'token' => $incidence->token,
                    'ot' => $ot,
                    'id' => $incidence->id,
                    'comment' => $request['incidence'][$index],
                    'new' => true
                ];

                Mail::to($agent['email'])->send(new NotifyMail($body));

                $body = null;
            }
        }

        return redirect()->route('tasks')->with('success','Task Complete!');
    }

    public function cancel(Request $request, $id) {
        $answer = Answer::find($id);
        $old_answer = $answer;

        $answer->answer = json_encode($request->get('reason'));
        $answer->status = 8;

        $answer->save();

        if($old_answer->status != $answer->status) {
            $log->saveLog($old_answer,$answer,'a');
        }

        return redirect()->route('tasks')->with('success','Task cancelled!');
    }
}
