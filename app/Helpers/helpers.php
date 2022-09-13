<?php

use App\Models\Answer;


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
    
        $body = [
            'visits' => $visits,
            'qc' => $qc,
            'send' => $send,
            'resp' => $resp,
            'per_con' => $per_con,
            'per_ans' => $per_ans
        ];
    
        return $body;
    }
}

if(!function_exists('last_month_day')) {
    function last_month_day() { 
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month, 0, $year));

        return date('Y-m-d', mktime(0,0,0, $month-1, $day, $year));
    }
}

if(!function_exists('first_month_day')) {
    function first_month_day() {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month-1, 1, $year));
    }
}