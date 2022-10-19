<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Store;
use App\Models\Answer;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function index($id) {
        return view('public.index',['id'=>$id]);
    }

    public function info($id, Request $request) {
        $first_day = ($request->init!=null) ? $request->init : $this->first_day((date('m')==0 ? 11 : date('m')-1),date('Y'));
        $last_day = ($request->final!=null) ? $request->final : $this->last_day((date('m')==0 ? 11 : date('m')-1),date('Y'));

        $client = Client::find($id);

        if($client->delegation == '00') {
            $clients = Client::where('father','=',$client->id)->orderBy('id','desc')->get();
            
            $delegations = [];
            foreach($clients as $key => $delegation) {
                $average = $this->getAverage($delegation,$first_day,$last_day);
                if($average!=false) {
                    $delegation['average'] = $average['media'];
                    $delegation['visits'] = $average['total'];
                    $delegations[]=$delegation;
                }
            }

            $response['delegations'] = $delegations;
            $response['central'] = $client;
            $response['type'] = 'delegation';

            return response()->json($response);
        } else {
            $average = $this->getAverage($client,$first_day,$last_day);
            if($average!=false) {
                $client['average'] = $average['media'];
                $client['visits'] = $average['total'];
            }
            $extra = getExtra($client,false,$first_day,$last_day);

            $answers = Answer::where('client','=',$client->id)->whereIn('status',[2,4,5])->whereBetween('updated_at',[$first_day,$last_day])->get();
            foreach($answers as &$answer) {
                $store =  Store::where('code','=',$answer->store)->first();
                $answer['shop'] = $store->name;
                $answer['workOrders'] = Task::where('answer_id', '=',$answer->id)->get();
            }

            $not_answers = Answer::where('client','=',$client->id)->where('status','=',3)->whereBetween('updated_at',[$first_day,$last_day])->get();
            $id = [];
            foreach($not_answers as $not_answer) {
                $id[] = $not_answer->store;
            }
            $shops = DB::select("SELECT stores.code, stores.name, COUNT(stores.id) as total FROM stores, answers WHERE stores.code = answers.store AND stores.client = ".$client->id." AND answers.status = 3 AND answers.updated_at BETWEEN '".$first_day."' AND '".$last_day."' GROUP BY stores.code, stores.name");
        
            $response['first_day'] = $first_day;
            $response['last_day'] = $last_day;
            $response['client'] = $client;
            $response['extra'] = $extra;
            $response['answers'] = $answers;
            $response['total'] = count($answers);
            $response['notResponds'] = $shops;
            $response['type'] = 'detail';

            return response()->json($response);
        }
    }

    public function detail($central, $delegation, Request $request) {
        $first_day = ($request->init!=null) ? $request->init : $this->first_day((date('m')==0 ? 11 : date('m')-1),date('Y'));
        $last_day = ($request->final!=null) ? $request->final : $this->last_day((date('m')==0 ? 11 : date('m')-1),date('Y'));

        $client = Client::find($delegation);
        $average = $this->getAverage($client,$first_day,$last_day);
        if($average!=false) {
            $client['average'] = $average['media'];
            $client['visits'] = $average['total'];
        }
        $extra = getExtra($client,false,$first_day,$last_day);

        $answers = Answer::where('client','=',$client->id)->whereIn('status',[2,4,5])->whereBetween('updated_at',[$first_day,$last_day])->get();
        foreach($answers as $answer) {
            $store =  Store::where('code','=',$answer->store)->first();
            $answer['shop'] = $store->name;
            $answer['workOrders'] = Task::where('answer_id', '=',$answer->id)->get();
        }

        $not_answers = Answer::where('client','=',$client->id)->where('status','=',3)->whereBetween('updated_at',[$first_day,$last_day])->get();
        $id = [];
        foreach($not_answers as $not_answer) {
            $id[] = $not_answer->store;
        }
        $shops = DB::select("SELECT stores.code, stores.name, COUNT(stores.id) as total FROM stores, answers WHERE stores.code = answers.store AND stores.client = ".$client->id." AND answers.status = 3 AND answers.updated_at BETWEEN '".$first_day."' AND '".$last_day."' GROUP BY stores.code, stores.name");

        $response['first_day'] = $first_day;
        $response['last_day']= $last_day;
        $response['client'] = $client;
        $response['extra'] = $extra;
        $response['answers'] = $answers;
        $response['total'] = count($answers);
        $response['notResponds'] = $shops;

        return response()->json($response);
    }

    private function getAverage($client,$first_day,$last_day) {
        $resp = [];

        $stores = Store::where('client','=',$client->id)->get();
        foreach($stores as $store) {
            $answer = Answer::where('store','=',$store->code)->whereIn('status',[2,4,5])->whereBetween('updated_at',[$first_day,$last_day])->get();
            if(count($answer) > 0) {
                foreach($answer as $ans) {
                    $response = json_decode($ans->answer,true);
                    $resp[] = $response['valoration'][0];
                }
            }
        }
        if(count($resp) > 0) {
            $total = array_sum($resp);
            $divisor = count($resp);
            $media = $total/$divisor;
            $body = [
                'media' => round($media,2),
                'total' => $divisor,
            ];
            return $body;
        } else {
            return false;
        }
    }

    private function last_day($month,$year) {
        $day = date("d", mktime(0,0,0, $month, 0, $year));
        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }
    private function first_day($month,$year) {
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }
    
}
