<?php

use App\Models\Answer;
use App\Models\Store;
use App\Models\Incidence;
use App\Models\Congratulation;
use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

if(!function_exists('getExtra')) {
    function getExtra($delegation,$agent=false,$first_day=false,$last_day=false) {
        $stores = Store::where('client','=',$delegation->id)->get();
        foreach($stores as $store) {
            $id[] = $store->code;
        }
        $visits = 0;
        $qc = 0;
        $send = 0;
        $resp = 0;
        
        $first_day = ($first_day==false) ? first_month_day() : $first_day;
        $last_day = ($last_day==false) ? last_month_day() : $last_day;
    
        $answers = Answer::whereIn('store',$id)->where('status','<>','8')->whereBetween('expiration',[$first_day,$last_day])->get();
        $visits = (int)count($answers);
    
        $answers = Answer::whereIn('store',$id)->whereIn('status',[2,3,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $contacts = (int)count($answers);
    
        $answers = Answer::whereIn('store',$id)->where('status','=','2')->whereBetween('expiration',[$first_day,$last_day])->get();
        $qc = (int)count($answers);
    
        $answers = Answer::whereIn('store',$id)->whereIn('status',[3,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $send = (int)count($answers);
    
        $answers = Answer::whereIn('store',$id)->whereIn('status',[4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $resp = (int)count($answers);
    
        $answers = Answer::whereIn('store',$id)->whereIn('status',[2,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $answered = (int)count($answers);
    
        $per_con = $visits==0 ? 0 : number_format(($contacts/$visits)*100,2);
        $per_ans = $contacts==0 ? 0 : number_format(($answered/$contacts)*100,2);
        $tot_ans = $visits==0 ? 0 : number_format(($answered/$visits)*100,2);
    
        $incidences = Incidence::whereIn('store',$id)->whereBetween('created_at',[$first_day,$last_day])->get();
        $incidence_total = count($incidences);
        $incidence_close = count(Incidence::whereIn('store',$id)->whereBetween('created_at',[$first_day,$last_day])->where('status','=',4)->get());

        $per_inc = $visits==0 ? 0 : number_format(($incidence_total/$visits)*100,2);
        $per_inc_close = $incidence_total==0 ? 0 : number_format(($incidence_close/$incidence_total)*100,2);

        $congratulations = count(Congratulation::where('client','=',$delegation->id)->whereBetween('created_at',[$first_day,$last_day])->get());

        $per_cong = $visits==0 ? 0 : number_format(($congratulations/$visits)*100,2);

        $time_total = 0;
        $count = 0;
        foreach($incidences as $incidence) {
            $count += 1;
            $time_total += timeLive($incidence);
        }
        $timing = calcMinutes(($count>0) ? $time_total/$count : 0);

        $body = [
            'visits' => $visits,
            'qc' => $qc,
            'send' => $send,
            'resp' => $resp,
            'per_con' => $per_con,
            'per_ans' => $per_ans,
            'tot_ans' => $tot_ans,
            'per_inc' => $per_inc,
            'per_inc_close' => $per_inc_close,
            'per_cong' => $per_cong,
            'timing' => $timing['days'].'d '.$timing['hours'].'m'
        ];
    
        return $body;
    }
}

if(!function_exists('last_month_day')) {
    function last_month_day($actually=false) { 
        $month = date('m');
        $year = date('Y');
        if($actually) {
            $day = date("d", mktime(0,0,0, $month+1, 0, $year));
            $month = $month;
        } else {
            $day = date("d", mktime(0,0,0, $month, 0, $year));
            $month = $month-1;
        }

        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }
}

if(!function_exists('first_month_day')) {
    function first_month_day($actually=false) {
        $month = date('m');
        $year = date('Y');
        if($actually) {
            $month = $month;
        } else {
            $month = $month-1;
        }
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }
}
if(!function_exists('purge_accent')) {
    function purge_accent($string) {
        $string = str_replace('ï¿½','ó',$string);
        $string = str_replace('Ã©','é',$string);
        $string = str_replace('Ã³','ò',$string);
        $string = str_replace('AbillÃ','Abillà',$string);
        $string = str_replace('MartÃ­n','Martín',$string);
        return $string;
    }
}

if(!function_exists('getAverage')) {
    function getAverage($client) {
        $resp = [];

        $first_day = first_month_day();
        $last_day = last_month_day();

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
} 

if(!function_exists('intToDays')) {
    function intToDays($diff){
        $segundos=$diff*60;
        
        //dias es la division de n segs entre 86400 segundos que representa un dia;
        $dias=floor($segundos/86400);
    
        //mod_hora es el sobrante, en horas, de la division de días;	
        $mod_hora=$segundos%86400;
        
        //hora es la division entre el sobrante de horas y 3600 segundos que representa una hora;
        $horas=floor($mod_hora/3600);
        
        //mod_minuto es el sobrante, en minutos, de la division de horas;	
        $mod_minuto=$mod_hora%3600;
        
        //minuto es la division entre el sobrante y 60 segundos que representa un minuto;
        $minutos=floor($mod_minuto/60);
        
        if($horas<=0){
            return $minutos.'m';
        }elseif($dias<=0){
            return $horas.'h '.$minutos.'m';
        }else{
            return $dias.'d '.$horas.'h '.$minutos.'m';
        }
    }
}

if(!function_exists('timeLive')) {
    function timeLive($incidence) {
        $time_total = 0;
        
        $pause = Log::where('table','=','i')->where('row_id','=',$incidence->id)->where('new','=',5)->orderBy('created','ASC')->get();
        $open = $incidence->created_at;
        
        if(count($pause)>0) {
            foreach($pause as $key => $init) {
                $close = Carbon::parse($init->created);
                
                $time_total += $open->diffInMinutes($close);
                
                $finish = Log::where('table','=','i')->where('row_id','=',$incidence->id)->where('old','=',5)->orderBy('created','ASC')->first();
                if($finish!=null) {
                    $open = Carbon::parse($finish->created);
                }
            }
        }
        $close = Carbon::parse($incidence->updated_at);

        $time_total += $open->diffInMinutes($close,false);

        return $time_total;
    }
}

if(!function_exists('calcMinutes')) {
    function calcMinutes($minutes) {
        $time = ['days' => 0, 'hours' => 0, 'minutes' => 0];

        while ($minutes >= 60) {
            if ($minutes >= 1440) {
                $time['days']++;
                $minutes = $minutes - 1440;
            } else if ($minutes >= 60) {
                $time['hours']++;
                $minutes = $minutes - 60;
            }
        }
        $time['minutes'] = number_format($minutes,2);
        return $time;
    }
}
