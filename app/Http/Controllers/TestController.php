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
            
            if($father->delegation == '00') {
                //busca hijos
                $sons = null;
                $delegations = Client::where('father','=',$father->id)->orderBy('id','desc')->get();
                
                foreach($delegations as $delegation) {
                    $average = $this->getAverage($delegation);
                    if($average != false) {
                        $sons[$delegation->name] = $average;
                    }
                }
                //se envia correo
                if(!is_null($sons)) {
                    Mail::to('test@optimaretail.es')->send(new ClientMonthly($sons));
                }
            } /*else {
                //busca tiendas
                $average = $this->getAverage($father);
                if($average != false) {
                    //se envia correo
                    Mail::to('test@optimaretail.es')->send(new ClientMonthly($average));
                }
            }*/
        }

        //return 0;
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
            return $media;
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
