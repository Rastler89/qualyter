<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Store;
use App\Models\Answer;
use Mail;
use App\Mail\ClientMonthly;

class TestController extends Controller
{
    public function handle()
    {
        $fathers = Client::whereNull('father')->get();

        foreach($fathers as $father) {
            
            if(strpos($father->email,',') !== false) {
                $emails = explode(',',$father->email);
                echo"<h3>".$father->name."</h3><pre>";print_r($emails);echo"</pre>";
            } else if(strpos($father->email,';') !== false) {
                $emails = explode(';',$father->email);
                echo"<h3>".$father->name."</h3><pre>";print_r($emails);echo"</pre>";
            } else if(strpos($father->email,"\n")) {
                $emails = explode("\n",$father->email);
                echo"<h3>".$father->name."</h3><pre>";print_r($emails);echo"</pre>";
            } else {
                echo"<h3>".$father->name." ((normal))</h3><pre>";print_r($father->email);echo"</pre>";
            }

                             
            
        }

        //return 0;
    }
    private function getExtra($delegations) {
        $visits = 0;
        $qc = 0;
        $send = 0;
        $resp = 0;

        $first_day = $this->first_month_day();
        $last_day = $this->last_month_day();

        foreach($delegations as $delegation) {
            $answers = Answer::where('client','=',$delegation->id)->whereBetween('expiration',[$first_day,$last_day])->get();
            $visits += count($answers);

            $answers = Answer::where('client','=',$delegation->id)->where('status','=','2')->whereBetween('expiration',[$first_day,$last_day])->get();
            $qc += count($answers);

            $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[3,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
            $send += count($answers);

            $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
            $resp += count($answers);
        }

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
                'media' => $media,
                'total' => $total,
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

    private function send($emails,$body) {
        foreach($emails as $email) {
            Mail::to($email)->send(new ClientMonthly($body));
        }
    }
}
