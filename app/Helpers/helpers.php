<?php

use App\Models\Answer;
use App\Models\Store;

if(!function_exists('getExtra')) {
    function getExtra($delegation,$agent=false) {
        $visits = 0;
        $qc = 0;
        $send = 0;
        $resp = 0;
        
        $first_day = first_month_day();
        $last_day = last_month_day();
    
        $answers = Answer::where('client','=',$delegation->id)->where('status','<>','8')->whereBetween('expiration',[$first_day,$last_day])->get();
        $visits = (int)count($answers);
    
        $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[2,3,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $contacts = (int)count($answers);
    
        $answers = Answer::where('client','=',$delegation->id)->where('status','=','2')->whereBetween('expiration',[$first_day,$last_day])->get();
        $qc = (int)count($answers);
    
        $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[3,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $send = (int)count($answers);
    
        $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $resp = (int)count($answers);
    
        $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[2,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
        $answered = (int)count($answers);
    
        $per_con = number_format(($contacts/$visits)*100,2);
        $per_ans = number_format(($answered/$contacts)*100,2);
        $tot_ans = number_format(($answered/$visits)*100,2);
    
        $body = [
            'visits' => $visits,
            'qc' => $qc,
            'send' => $send,
            'resp' => $resp,
            'per_con' => $per_con,
            'per_ans' => $per_ans,
            'tot_ans' => $tot_ans
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