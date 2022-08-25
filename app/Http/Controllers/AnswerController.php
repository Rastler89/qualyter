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
use App\Mail\ManagerMail;
use App\Mail\StoreMail;
use App\Mail\ResponseMail;
use App\Mail\TechnicianMail;
use Artisan;

class AnswerController extends Controller
{
    public function index(Request $request) {
        $filters = $request->query();

        $pre_answers = Answer::query();

        if(isset($filters['filtered'])  && isset($filters['filters'])) {
            $filters = $filters['filters'];
        } else {
            if(count($filters)==0) {
                $filters['start_date_closing'] = date('Y-m-d',strtotime("-7 days"));
            }
        }


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
                $build_store = Store::where('code','=',$t->store)->first();
                if($t->answer_id == null) {
                    $build_answer = Answer::where('expiration','=',date('Y-m-d', strtotime(str_replace('/','-',$t->expiration))))->where('store','=',$t->store)->first();
                    if($build_answer == null) {
                        $build_answer = new Answer;
                        $build_answer->expiration = date('Y-m-d', strtotime(str_replace('/','-',$t->expiration)));
                        $build_answer->status = 0;
                        $build_answer->store = $t->store;
                        $build_answer->client = ($build_store['client']==null || $build_store['client']=='') ? 1 : $build_store['client'];
                        $build_answer->token = Str::random(8);
                        $build_answer->save();
                    }
                    $build_answer->tasks()->save($t);
                }
                $id[] = $t->answer_id;
            }
            $pre_answers->whereIn('id',$id);
        }

        if(!empty($filters['agent']) && $filters['agent'] != '') {
            $id=[];
            $tasks = Task::where('owner','=',$filters['agent'])->get();
            foreach($tasks as $t) {
                $id[] = $t->answer_id;
            }
            $pre_answers->whereIn('id',$id);
        }

        if(!empty($filters['start_date_created']) && $filters['start_date_created'] != '') {
            if(!empty($filters['end_date_created']) && $filters['end_date_created'] != '') {
                if($filters['start_date_created']==$filters['end_date_created']) {
                    $pre_answers->whereBetween('created_at',[$filters['start_date_created'].' 00:00:00',$filters['end_date_created'].' 23:59:59']);
                } else {
                    $pre_answers->whereBetween('created_at',[$filters['start_date_created'],$filters['end_date_created']]);
                }
            } else {
                $pre_answers->where('created_at','>=',$filters['start_date_created']);
            }
        } else {
            if(!empty($filters['end_date_created']) && $filters['end_date_created'] != '') {
                $pre_answers->where('created_at','<=',$filters['end_date_created']);
            }
        }

        if(!empty($filters['start_date_closing']) && $filters['start_date_closing'] != '') {
            if(!empty($filters['end_date_closing']) && $filters['end_date_closing'] != '') {
                if($filters['start_date_created']==$filters['end_date_created']) {
                    $pre_answers->whereBetween('expiration',[$filters['start_date_closing'].' 00:00:00',$filters['end_date_closing'].' 23:59:59']);
                } else {
                    $pre_answers->whereBetween('expiration',[$filters['start_date_closing'],$filters['end_date_closing']]);
                }
            } else {
                $pre_answers->where('expiration','>=',$filters['start_date_closing']);
            }
        } else {
            if(!empty($filters['end_date_closing']) && $filters['end_date_closing'] != '') {
                $pre_answers->where('expiration','<=',$filters['end_date_closing']);
            }
        }

        $pre_answers->whereIn('status',[0,1]);

        $answers = $pre_answers->sortable()->paginate(10);
        $stores = Store::all();
        $clients = Client::all();
        $agents = Agent::all();
        $users = User::all();

        $id = auth()->user()->id;
        return view('admin.task.index',['answers' => $answers, 'stores' => $stores, 'clients' => $clients, 'id' => $id, 'agents' => $agents, 'filters' => $filters, 'users' => $users]);
    }

    public function call($id) {
        $user = $_GET['user'];
        $artisan = Artisan::call('call:store',['user'=>$user, 'id'=>$id, 'type'=>'answer']);
        $output = Artisan::output();
        return response()->json($output);
    }
    
    public function view($id) {
        $log = new AuditionController();
        $answer = Answer::find($id);
        $old_answer = Answer::find($id);
        
        $store = Store::where('code','=',$answer->store)->where('client','=',$answer->client)->first();

        if(env('APP_NAME')!='QualyterTEST') {
            $artisan = Artisan::call('call:store',['user'=>auth()->user()->id, 'id'=>$answer->id, 'type'=>'answer']);
            $output = Artisan::output();
        }
        
        if($answer->status > 1) {
            if($answer->status == 2 || $answer->status == 4 || $answer->status == 5) {
                return redirect()->route('answers.view',['id' => $answer->id]);
            } else if($answer->status == 3) {
                return redirect()->route('tasks')->with('alert','This survey has been sent to shop');
            } else if($answer->status == 8) {
                return redirect()->route('tasks')->with('alert','It was cancelled, reason: '.$answer->answer);
            } else {
                abort(403, 'Unauthorized action.');
            }
        }

        //Add user and modify status
        $answer->status = 1;
        $answer->user = auth()->user()->id;
        $answer->save();
        
        if($old_answer->status != $answer->status) {
            $log->saveLog($old_answer,$answer,'a');
        }

        $agents = Agent::all();
        $tasks = Task::where('answer_id','=',$answer->id)->get();
        foreach($tasks as $task) {
            $owners[] = $task->owner;
        }

        if(is_null($store->email) || $store->email == '') {
            $store->email = '-';
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

        if($request->get('emails') != '') {
            $store = Store::where('code','=',$answer->store)->get();

            $body['store'] = $store[0];

            if(strpos($request->get('emails'),',') !== false) {
                $emails = explode(',',$request->get('emails'));
                $this->send($emails,$body);
            } else if(strpos($request->get('emails'),';') !== false) {
                $emails = explode(';',$request->get('emails'));
                $this->send($emails,$body);
            } else if(strpos($request->get('emails'),"\n")) {
                $emails = explode("\n",$request->get('emails'));
                $this->send($emails,$body);
            } else {
                Mail::to($request->get('emails'))->send(new TechnicianMail($body));
            }
        }

        return redirect()->route('tasks')->with('success','Task Complete!');
    }

    public function sendTechnician(Request $request, $id) {

        $answer = Answer::find($id);
        $ans = json_decode($answer->answer,true);
        $stores = Store::where('code','=',$answer->store)->get();

        $body['valoration'][1] = $ans['valoration'][0];
        $body['valoration'][0] = $ans['valoration'][1];
        $body['valoration'][3] = $ans['valoration'][2];
        $body['valoration'][2] = $ans['valoration'][3];
        $body['store'] = $stores[0];
        if(strpos($request->get('emails'),',') !== false) {
            $emails = explode(',',$request->get('emails'));
            $this->send($emails,$body);
        } else if(strpos($request->get('emails'),';') !== false) {
            $emails = explode(';',$request->get('emails'));
            $this->send($emails,$body);
        } else if(strpos($request->get('emails'),"\n")) {
            $emails = explode("\n",$request->get('emails'));
            $this->send($emails,$body);
        } else {
            Mail::to($request->get('emails'))->locale($body['store']->language)->send(new TechnicianMail($body));
        }

        return redirect()->route('answers')->with('success','Send review!');
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

        $workOrders = Task::where('answer_id','=',$answer->id)->get();

        $body = [
            'id' => $answer->id,
            'client' => $client->name,
            'store' => $store->name,
            'locale' => ($store->language != null) ? $store->language : 'en',
            'token' => $answer->token,
            'date' => $answer->expiration,
            'workOrders' => $workOrders,
        ];
        if(env('APP_NAME')=='QualyterTEST') {
            Mail::to('test@optimaretail.es')->locale($body['locale'])->send(new StoreMail($body));
        } else {
            $emails = explode(';',$store->email);
            foreach($emails as $email) {
                Mail::to($email)->locale($body['locale'])->send(new StoreMail($body));
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
        if(isset($filters['filtered'])  && isset($filters['filters'])) {
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
            $tasks = Task::where('owner','=',$filters['agent'])->get();
            foreach($tasks as $t) {
                $id[] = $t->answer_id;
            }
            $pre_answers->whereIn('id',$id);
        }

        if(!empty($filters['start_date_created']) && $filters['start_date_created'] != '') {
            if(!empty($filters['end_date_created']) && $filters['end_date_created'] != '') {
                if($filters['start_date_created']==$filters['end_date_created']) {
                    $pre_answers->whereBetween('created_at',[$filters['start_date_created'].' 00:00:00',$filters['end_date_created'].' 23:59:59']);
                } else {
                    $pre_answers->whereBetween('created_at',[$filters['start_date_created'],$filters['end_date_created']]);
                }
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
                if($filters['start_date_closed']==$filters['end_date_closed']) {
                    $pre_answers->whereBetween('updated_at',[$filters['start_date_closed'].' 00:00:00',$filters['end_date_closed'].' 23:59:59']);
                } else {
                    $pre_answers->whereBetween('updated_at',[$filters['start_date_closed'],$filters['end_date_closed']]);
                }
            } else {
                $pre_answers->where('updated_at','>=',$filters['start_date_closed']);
            }
        } else {
            if(!empty($filters['end_date_closed']) && $filters['end_date_closed'] != '') {
                $pre_answers->where('updated_at','<=',$filters['end_date_closed']);
            }
        }

        if(!empty($filters['start_date_closing']) && $filters['start_date_closing'] != '') {
            if(!empty($filters['end_date_closing']) && $filters['end_date_closing'] != '') {
                if($filters['start_date_created']==$filters['end_date_created']) {
                    $pre_answers->whereBetween('expiration',[$filters['start_date_closing'].' 00:00:00',$filters['end_date_closing'].' 23:59:59']);
                } else {
                    $pre_answers->whereBetween('expiration',[$filters['start_date_closing'],$filters['end_date_closing']]);
                }
            } else {
                $pre_answers->where('expiration','>=',$filters['start_date_closing']);
            }
        } else {
            if(!empty($filters['end_date_closing']) && $filters['end_date_closing'] != '') {
                $pre_answers->where('expiration','<=',$filters['end_date_closing']);
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

        if(!empty($filters['team']) && $filters['team'] != '') {
            $id=[];
            $agents = Agent::where('team','=',$filters['team'])->get();
            foreach($agents as $agent) {
                $tasks = Task::where('owner','=',$agent->id)->get();
                foreach($tasks as $t) {
                    $id[] = $t->answer_id;
                }
            }
            $pre_answers->whereIn('id',$id);
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

        if(isset($filters['sort'])) {
            $answers = $pre_answers->sortable()->paginate(10);
        } else {
            $answers = $pre_answers->orderBy('created_at','DESC')->paginate(10);
        }

        $stores = Store::all();
        $clients = Client::all();
        $agents = Agent::all();
        $workOrders = Task::all();
        $teams = Team::all();

        return view('admin.answer.index', ['answers' => $answers, 'agents' => $agents, 'stores' => $stores, 'clients' => $clients, 'workOrders' => $workOrders, 'filters' => $filters, 'teams' => $teams]);
    }

    public function viewAnswer(Request $request, $id) {
        $answer = Answer::find($id);
        $agents = Agent::all();
        $store = Store::where('code','=',$answer->store)->first();
        $tasks = Task::where('answer_id','=',$answer->id)->get();

        $incidence = [];
        foreach($tasks as $task) {
            $code = '%'.str_replace('/','%',$task->code).'%';
            $inc = Incidence::where('order','like',$code)->get();
            if(isset($inc[0])) {
                $incidence[] = $inc[0];
            }
        }

        $res = [];
        $answers = json_decode($answer->answer,true);
        foreach($answers['valoration'] as $index => $an) {
            $res[$index]['value'] = $an;
            $res[$index]['text'] = $answers['comment'][$index];
        }
        foreach($tasks as $task) {
            $owners[] = $task->owner;
        }
        if(isset($owners)) {
            $owners = Agent::find($owners);
        } else {
            $owners = false;
        }
        if($answer->callId != null || $answer->callId != '') {
            $answer->calls = $this->getCalls($answer->callId);
        }
        return view('admin.answer.view', ['answer' => $answer, 'store' => $store, 'answers' => $res, 'tasks' => $tasks, 'agents' => $agents, 'owners' => $owners, 'incidences' => $incidence]);
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

    public function reactivate($id) {
        $answer = Answer::find($id);
        $answer->status = 1;
        $answer->user = auth()->user()->id;

        $answer->save();

        return redirect()->route('answers')->with('success','Answer re-activated');
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
                    Mail::to($user->email)->send(new ManagerMail($body));
                    Mail::to('fran.ullod@optimaretail.es')->send(new ManagerMail($body));
                }

                $body = null;
            }
        }
    }

    private function send($emails,$body) {
        foreach($emails as $email) {
            Mail::to($email)->locale($body['store']->language)->send(new TechnicianMail($body));
        }
    }

    private function getCalls($calls) {
        $call = [];
        $callIds = json_decode($calls,true);

        foreach($callIds as $callid) {
            if (strpos($callid, 'E') !== false) {
                $callid = number_format($callid,0,'','');
            }
            
            $url = "https://public-api.ringover.com/v2/calls/".$callid;
            $authorization = 'Authorization: 138a032c631da0db13b4d1252742ebb2ce17599a';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$authorization));

            $response = curl_exec($curl);
            $response = json_decode($response,true);
            if($response!=null) {
                $call[] = $response['list'][0];
            }
        }
        return $call;
    }
}
