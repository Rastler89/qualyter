<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Answer;
use App\Models\Client;
use App\Models\Store;
use App\Models\Task;
use App\Models\Incidence;
use App\Models\User;
use App\Models\Team;
use App\Http\Controllers\AuditionController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use App\Mail\NotifyMail;
use App\Mail\StoreMail;
use App\Mail\ResponseMail;

class AnswerController extends Controller
{
    public function index(Request $request) {
        $client = $request->query('client');
        $store = $request->query('store');
        $work = $request->query('workorder');

        $pre_answers = Answer::query();

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

        return view('admin.task.index',['answers' => $answers, 'stores' => $stores, 'clients' => $clients, 'id' => $id, 'filterStore' => $store, 'filterClient' => $client, 'filterWO' => $work]);
    }

    public function view($id) {
        $log = new AuditionController();
        $answer = Answer::find($id);
        $old_answer = Answer::find($id);

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
        return view('admin.task.view', ['answer' => $answer, 'store' => $store, 'tasks' => $tasks, 'agents' => $agents, 'owners' => $owners]);
    }

    public function response(Request $request, $id) {
        $log = new AuditionController();
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
        $old_answer = Answer::find($id);

        if($answer->status != 1) {
            return redirect()->route('tasks')->with('alert','This answers exist! Not modified');
        }

        $answer->status = 2;
        $answer->answer = json_encode($body,true);

        $answer->save();

        if($old_answer->status != $answer->status) {
            $log->saveLog($old_answer,$answer,'a');
        }
        $this->createIncidence($request,$answer);

        return redirect()->route('tasks')->with('success','Task Complete!');
    }

    public function cancel(Request $request, $id) {
        $log = new AuditionController();
        $answer = Answer::find($id);
        $old_answer = Answer::find($id);

        $answer->answer = json_encode($request->get('reason'));
        $answer->status = 8;

        $answer->save();

        if($old_answer->status != $answer->status) {
            $log->saveLog($old_answer,$answer,'a');
        }

        return redirect()->route('tasks')->with('success','Task cancelled!');
    }

    public function notrespond(Request $request, $id) {
        $log = new AuditionController();
        $answer = Answer::find($id);
        $store = Store::where('code','=',$answer->store)->first();
        $client = Client::find($answer->client);

        $old_answer = Answer::find($id);

        $answer->answer = json_encode($request->get('reason'));
        $answer->user = auth()->user()->id;
        $answer->status = 3;

        $answer->save();

        if($old_answer->status != $answer->status) {
            $log->saveLog($old_answer,$answer,'a');
        }
        $body = [
            'id' => $answer->id,
            'client' => $client->name,
            'store' => $store->name,
            'locale' => ($store->language != null) ? $store->language : 'en',
            'token' => $answer->token,
            'date' => $answer->expiration
        ];
        if(env('APP_NAME')=='QualyterTEST') {
            Mail::to('test@optimaretail.es')->locale($body['locale'])->send(new StoreMail($body));
        } else {
            $emails = explode(';',$store->email);
            foreach($emails as $email) {
                Mail::to($email)->send(new StoreMail($body));
            }
        }

        return redirect()->route('tasks')->with('success','Questionnaire sended!');
    }

    public function viewSurvey(Request $request, $id) {
        $answer = Answer::find($id);

        if($answer->token != $request->get('code')) {
            abort(403, 'Unauthorized action.');
        }

        if($answer->status == 4) {
            return view('public.thanksStore');
        }

        $store = Store::where('code','=',$answer->store)->first();

        return view('public.store', ['store' => $store, 'answer' => $answer]);
    }

    public function responseSurvey(Request $request, $id) {
        $log = new AuditionController();
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
        $old_answer = Answer::find($id);

        $answer->status = 4;
        $answer->answer = json_encode($body,true);

        $answer->save();

        if($old_answer->status != $answer->status) {
            $log->saveLog($old_answer,$answer,'a');
        }

        $owner = User::find($answer->user);
        $store = Store::where('code','=',$answer->store)->first();

        $body = [
            'id' => $answer->id,
            'agent' => $owner->name,
            'store' => $store->name,
            'token' => $answer->token
        ];

        if(env('APP_NAME')=='QualyterTEST') {
            Mail::to('test@optimaretail.es')->send(new ResponseMail($body));
        } else {
            Mail::to($owner->email)->send(new ResponseMail($body));
        }
        return view('public.thanksStore');
    }

    public function answers(Request $request) {
        $filters = $request->query();
        if(isset($filters['filtered'])) {
            $filters = $filters['filters'];
        }
        
        $pre_answers = Answer::where('status','>',1);

        /* Start Filters */
        if(!empty($filters['store']) && $filters['store'] != '') {
            $id = [];
            $stores = Store::where('name','LIKE','%'.$filters['store'].'%')->get();
            foreach($stores as $s) {
                $id[] = $s->code;
            }
            $pre_answers->whereIn('store',$id);
        }

        if(!empty($filters['client']) && $filters['client'] != '') {
            $id = [];
            $clients = Client::where('name','LIKE','%'.$filters['client'].'%')->get();
            foreach($clients as $c) {
                $id[] = $c->id;
            }
            $pre_answers->whereIn('client',$id);
        }

        if(!empty($filters['workOrder']) && $filters['workOrder'] != '') {
            $id=[];
            $tasks = Task::where('code','LIKE','%'.$filters['workOrder'].'%')->get();
            foreach($tasks as $t) {
                $id[] = $t->answer_id;
            }
            $pre_answers->whereIn('id',$id);
        }

        if(!empty($filters['agent']) && $filters['agent'] != '') {
            $id=[];
            $tasks = Task::where('owner','=',$filters['agent']);
            foreach($tasks as $t) {
                $id[] = $t->answer_id;
            }
            $pre_answers->whereIn('id',$id);
        }

        if(!empty($filters['start_date_created']) && $filters['start_date_created'] != '') {
            if(!empty($filters['end_date_created']) && $filters['end_date_created'] != '') {
                $pre_answers->whereBetween('created_at',[$filters['start_date_created'],$filters['end_date_created']]);
            } else {
                $pre_answers->where('created_at','>=',$filters['start_date_created']);
            }
        } else {
            if(!empty($filters['end_date_created']) && $filters['end_date_created'] != '') {
                $pre_answers->where('created_at','<=',$filters['end_date_created']);
            }
        }

        if(!empty($filters['start_date_closed']) && $filters['start_date_closed'] != '') {
            if(!empty($filters['end_date_closed']) && $filters['end_date_closed'] != '') {
                $pre_answers->whereBetween('created_at',[$filters['start_date_closed'],$filters['end_date_closed']]);
            } else {
                $pre_answers->where('created_at','>=',$filters['start_date_closed']);
            }
        } else {
            if(!empty($filters['end_date_closed']) && $filters['end_date_closed'] != '') {
                $pre_answers->where('created_at','<=',$filters['end_date_closed']);
            }
        }

        if(!empty($filters['start_date_closing']) && $filters['start_date_closing'] != '') {
            if(!empty($filters['end_date_closing']) && $filters['end_date_closed'] != '') {
                $pre_answers->whereBetween('created_at',[$filters['start_date_closing'],$filters['end_date_closing']]);
            } else {
                $pre_answers->where('created_at','>=',$filters['start_date_closing']);
            }
        } else {
            if(!empty($filters['end_date_closing']) && $filters['end_date_closing'] != '') {
                $pre_answers->where('created_at','<=',$filters['end_date_closing']);
            }
        }

        if(!empty($filters['status'])) {
            $status = [];
            foreach($filters['status'] as $index => $value) {
                if($value=='true') {
                    $status[] = $index;
                }
            }
            $pre_answers->whereIn('status',$status);
        }

        /* End filters */

        $rol = auth()->user()->roles;
        $rol = json_decode($rol[0]);
        if($rol->id == 2) {
            $id = [];
            $teams = Team::where('manager','=',auth()->user()->id)->get();
            foreach($teams as $team) {
                $url[] = $team->url;
            }
            $agents = Agent::whereIn('team',$url)->get();
            foreach($agents as $agent) {
                $id[] = $agent->id;
            }
            $tasks = Task::whereIn('owner',$id)->get();
            $id = [];
            foreach($tasks as $t) {
                $id[] = $t->answer_id;
            }
            $pre_answers->whereIn('id',$id);
            
        }

        $answers = $pre_answers->sortable()->paginate(10);
        $stores = Store::all();
        $clients = Client::all();
        $agents = Agent::all();
        $workOrders = Task::all();

        return view('admin.answer.index', ['answers' => $answers, 'agents' => $agents, 'stores' => $stores, 'clients' => $clients, 'workOrders' => $workOrders, 'filters' => $filters]);
    }

    public function viewAnswer(Request $request, $id) {
        $answer = Answer::find($id);
        $agents = Agent::all();
        $store = Store::where('code','=',$answer->store)->first();
        $tasks = Task::where('answer_id','=',$answer->id)->get();
        
        $res = [];
        $answers = json_decode($answer->answer,true);
        foreach($answers['valoration'] as $index => $an) {
            $res[$index]['value'] = $an;
            $res[$index]['text'] = $answers['comment'][$index];
        }
        foreach($tasks as $task) {
            $owners[] = $task->owner;
        }

        $owners = Agent::find($owners);
        
        return view('admin.answer.view', ['answer' => $answer, 'store' => $store, 'answers' => $res, 'tasks' => $tasks, 'agents' => $agents, 'owners' => $owners]);
    }

    public function revised(Request $request, $id) {
        $log = new AuditionController();
        $answer = Answer::find($id);
        $old_answer = Answer::find($id);

        $answer->status = 5;

        $answer->save();

        if($old_answer->status != $answer->status) {
            $log->saveLog($old_answer,$answer,'a');
        }

        $this->createIncidence($request,$answer);

        return redirect()->route('answers')->with('success','Answer closed!');
    }

    public function complete($id) {
        $log = new AuditionController();
        $answer = Answer::find($id);
        $old_answer = Answer::find($id);

        $answer->status = 5;

        $answer->save();

        return redirect()->route('answers')->with('success','Answer closed!');
    }

    private function createIncidence($request,$answer) {
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
                if(env('APP_NAME')=='QualyterTEST') {
                    Mail::to('test@optimaretail.es')->send(new NotifyMail($body));
                } else {
                    $team = Team::where('url','=',$agent->team)->first();
                    $user = User::find($team->manager);
                    
                    Mail::to($agent->email)->send(new NotifyMail($body));
                    Mail::to($user->email)->send(new NotifyMail($body));
                }

                $body = null;
            }
        }
    }
}
