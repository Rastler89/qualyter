<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Store;
use App\Models\Answer;

class TestController extends Controller
{
    public function handle()
    {
        info("Cron Job running at ". now());
        $first_day = $this->first_month_day();
        $last_day = $this->last_month_day();

        $fathers = Client::whereNull('father')->get();

        foreach($fathers as $father) {
            if($father->delegation == '00') {
                //busca hijos

            } else {
                //busca tiendas
                $stores = Store::where('client','=',$father->id)->get();
                foreach($stores as $store) {
                    $answer = 
                }
            }
        }
        
        echo"<pre>";print_r($fathers);echo"</pre>";
        //Mail::to('test@optimaretail.es')->send(new ClientMonthly());

        //return 0;
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
