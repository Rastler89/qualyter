<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Agent;
use App\Models\Answer;
use App\Models\Client;
use App\Models\Store;
use App\Models\Task;
use App\Models\Incidence;
use App\Models\User;
use App\Models\Team;
use Response;


class ExportController extends Controller
{
    public function answer(Request $request) {
        $headers = [
            'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'          => 'text/csv',
            'Content-Disposition'   => 'attachment; filename=answers.csv',
            'Expires'               => '0',
            'Pragma'                => 'public'
        ];

        $filters = $request->query();
        if(isset($filters['filters'])) {
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
                if($filters['start_date_created']==$filters['end_date_created']) {
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
        } else {
            $pre_answers->whereIn('status',[2,3,4,5,8]);
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

        
        $list = $pre_answers->get()->toArray();

        array_unshift($list, array_keys($list[0]));
        foreach($list as $key => &$l) {
            if($key != 0) {
                $client = Client::find($l['client']);
                $l['client'] = $client->name;
                $store = Store::where('code','=',$l['store'])->first();
                $l['store'] = $store->name;
                $answers = json_decode($l['answer']);
                if(gettype($answers)=='string') {
                    $l['cancelled'] = $answers;
                } else if(gettype($answers) == 'NULL') {
                    //nothing
                 } else {
                    foreach($answers->valoration as $i => $answer) {
                        $name1 = 'point'.$i;
                        $name2 = 'comment'.$i;
                        $l[$name1] = $answer;
                        $l[$name2] = $answers->comment[$i];
                    }
                }
            } else {
                for($i=0;$i<4;$i++) {
                    $l[]='point'.$i;
                    $l[]='comment'.$i;
                }
            }
        }
        $callback = function() use ($list) 
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) { 
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback,200,$headers);
    }
}
