<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Agent;
use App\Models\Task;

class ApiController extends Controller
{
    public function window(Request $request) {
        $body = json_decode($request->getContent(), true);

        if($request->monthly==true) {
            $monday = $this->first_month_day(0);
            $suneday = $this->last_month_day(0);
            
            $old_monday = $this->first_month_day(1);
            $old_suneday = $this->last_month_day(1);
        } else {
            $current_day = date("N");
            $days_to_sunday = 7 - $current_day;
            $days_from_monday = $current_day - 1;
            $monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));
            $suneday = date("Y-m-d", strtotime("+ {$days_to_sunday} Days"));
            
            $old_monday = date("Y-m-d",strtotime($monday."-7 days"));
            $old_suneday = date("Y-m-d",strtotime($suneday."-7 days"));
        }


        for($i=1;$i<=9;$i++) {
            $agents = Agent::where('team','LIKE','%'.$i.'%')->get();
            $id = [];
            foreach($agents as $agent) {
                $id[] = $agent->id;
            }
            $tasks = Task::whereIn('owner',$id)->get();
            
            $id = [];
            foreach($tasks as $task) {
                $id[] = $task->answer_id;
            }

            $answers = Answer::whereIn('status',[2,4,5])->whereBetween('expiration',[$monday,$suneday])->whereIn('id',$id)->get();
    
            $results = $this->media($answers);
    
            $old_answers = Answer::whereIn('status',[2,4,5])->whereBetween('expiration',[$old_monday,$old_suneday])->whereIn('id',$id)->get();
    
            $old_results = $this->media($old_answers);
    
            $team['new'] = $results;
            $team['old'] = $old_results;

            $response[$i] = $team;

        }
        $all_answers = Answer::whereIn('status',[2,4,5])->whereBetween('expiration',[$monday,$suneday])->get();
        $all_results = $this->media($all_answers);
        $all_old_answers = Answer::whereIn('status',[2,4,5])->whereBetween('expiration',[$old_monday,$old_suneday])->get();
        $all_old_results = $this->media($all_old_answers);

        $team['new'] = $all_results;
        $team['old'] = $all_old_results;
        $response['all'] = $team;


        return response()->json($response);
       
    }

    public function emails(Request $request) {
        $body = json_decode($request->getContent(), true);
        
        $answers = Answer::whereIn('status',[3,4,5]);

        $answers = $this->dating($body,$answers);

        $answers = $answers->get();

        $res = [];
        $res['total'] = count($answers);

        if($body['not_respond']) {
            $responds = Answer::where('status','=',3);
            $responds = $this->dating($body,$responds);
            $responds = $responds->get();
            $res['not_respond'] = count($responds);
        }
        foreach($answers as $answer) {
            $res['body'][] = $answer;
        }

        return response()->json($res);
    }

    private function media($answers) {
        $question = [];
        $question[0] = 0;
        $question[1] = 0;
        $question[2] = 0;
        $question[3] = 0;

        $sum = 0;

        foreach($answers as $answer) {
            $res = json_decode($answer->answer);
            $question[0]+=$res->valoration[0];
            $question[1]+=$res->valoration[1];
            $question[2]+=$res->valoration[2];
            $question[3]+=$res->valoration[3];
            
            $sum++;
        }

        if($sum != 0) {
            $question[0] = $question[0] / $sum;
            $question[1] = $question[1] / $sum;
            $question[2] = $question[2] / $sum;
            $question[3] = $question[3] / $sum;
        } else {

        }

        $question['total'] = $sum;
        

        return $question;
    }

    private function dating($body,$answers)  {
        if($body['start_date'] != null) {
            //tenemos fecha inicio
            if($body['end_date'] != null) {
                //tenemos fechas
                $answers->whereBetween('expiration',[$body['start_date'],$body['end_date']]);
            } else {
                //hasta fecha actual
                $answers->where('expiration','<=',$body['start_date']);
            }
        } else {
            if($body['end_date'] != null) {
                //tenemos fecha final
                $answers->where('expiration','>=',$body['end_date']);
            }
        }

        return $answers;
    }

    private function last_month_day($diff) { 
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month, 0, $year));
        $day = ($diff==0) ? $day+1 : $day;
        return date('Y-m-d', mktime(0,0,0, $month-$diff, $day, $year));
    }

    /** Actual month first day **/
    private function first_month_day($diff) {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month-$diff, 1, $year));
    }
}
