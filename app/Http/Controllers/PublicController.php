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
        $month = date('m')-1;

        $client = Client::find($id);


        if($client->delegation == '00') {
            $clients = Client::where('father','=',$client->id)->orderBy('id','desc')->get();
            
            $delegations = [];
            foreach($clients as $key => $delegation) {
                $average = $this->getAverage($delegation);
                if($average!=false) {
                    $delegation['average'] = $average['media'];
                    $delegation['visits'] = $average['total'];
                    $delegations[]=$delegation;
                }
            }
            return view('public.index',['delegations' => $delegations, 'month' => $month, 'central' => $client, 'type' => 'delegation']);
        } else {
            $first_day = $this->first_month_day();
            $last_day = $this->last_month_day();

            $average = $this->getAverage($client);
            if($average!=false) {
                $client['average'] = $average['media'];
                $client['visits'] = $average['total'];
            }
            $extra = $this->getExtra($client);

            $answers = Answer::where('client','=',$client->id)->whereIn('status',[2,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
            foreach($answers as &$answer) {
                $store =  Store::where('code','=',$answer->store)->first();
                $answer['shop'] = $store->name;
                $answer['workOrders'] = Task::where('answer_id', '=',$answer->id)->get();
            }

            $not_answers = Answer::where('client','=',$client->id)->where('status','=',3)->whereBetween('expiration',[$first_day,$last_day])->get();
            $id = [];
            foreach($not_answers as $not_answer) {
                $id[] = $not_answer->store;
            }
            $shops = DB::select("SELECT stores.code, stores.name, COUNT(stores.id) as total FROM stores, answers WHERE stores.code = answers.store AND stores.client = ".$client->id." AND answers.status = 3 AND answers.expiration BETWEEN '".$first_day."' AND '".$last_day."' GROUP BY stores.code, stores.name");
        
            return view('public.detail',['first_day'=>$first_day, 'last_day'=>$last_day, 'client'=>$client, 'extra' => $extra, 'answers' => $answers, 'total' => count($answers), 'notResponds' => $shops]);
        }
    }

    public function detail($central, $delegation) {
        $first_day = $this->first_month_day();
        $last_day = $this->last_month_day();

        $client = Client::find($delegation);
        $average = $this->getAverage($client);
        if($average!=false) {
            $client['average'] = $average['media'];
            $client['visits'] = $average['total'];
        }
        $extra = $this->getExtra($client);

        $answers = Answer::where('client','=',$client->id)->whereIn('status',[2,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        foreach($answers as &$answer) {
            $store =  Store::where('code','=',$answer->store)->first();
            $answer['shop'] = $store->name;
            $answer['workOrders'] = Task::where('answer_id', '=',$answer->id)->get();
        }

        $not_answers = Answer::where('client','=',$client->id)->where('status','=',3)->whereBetween('expiration',[$first_day,$last_day])->get();
        $id = [];
        foreach($not_answers as $not_answer) {
            $id[] = $not_answer->store;
        }
        $shops = DB::select("SELECT stores.code, stores.name, COUNT(stores.id) as total FROM stores, answers WHERE stores.code = answers.store AND stores.client = ".$client->id." AND answers.status = 3 AND answers.expiration BETWEEN '".$first_day."' AND '".$last_day."' GROUP BY stores.code, stores.name");
        return view('public.detail',['first_day'=>$first_day, 'last_day'=>$last_day, 'client'=>$client, 'extra' => $extra, 'answers' => $answers, 'total' => count($answers), 'notResponds' => $shops]);
    }


    private function getExtra($delegation) {
        $visits = 0;
        $qc = 0;
        $send = 0;
        $resp = 0;
        
        $first_day = $this->first_month_day();
        $last_day = $this->last_month_day();

        $answers = Answer::where('client','=',$delegation->id)->whereBetween('expiration',[$first_day,$last_day])->get();
        $visits += count($answers);

        $answers = Answer::where('client','=',$delegation->id)->where('status','=','2')->whereBetween('expiration',[$first_day,$last_day])->get();
        $qc += count($answers);

        $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[3,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $send += count($answers);

        $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $resp += count($answers);

        $body = [
            'visits' => $visits,
            'qc' => $qc,
            'send' => $send,
            'resp' => $resp
        ];

        return $body;
    }
    private function getAverage($client) {
        $resp = [];

        $first_day = $this->first_month_day();
        $last_day = $this->last_month_day();

        $stores = Store::where('client','=',$client->id)->get();
        foreach($stores as $store) {
            $answer = Answer::where('store','=',$store->code)->whereIn('status',[2,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
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
    /** Actual month last day **/
    private function last_month_day() { 
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month, 0, $year));

        return date('Y-m-d', mktime(0,0,0, $month-1, $day, $year));
    }

    /** Actual month first day **/
    private function first_month_day() {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month-1, 1, $year));
    }
}
