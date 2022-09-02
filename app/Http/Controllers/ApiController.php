<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Agent;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
/**
 * @OA\Info(title="OptimaQuality API", version="1.0")
 * 
 * @OA\Server(url="http://localhost:8000", description="Test")
 * @OA\Server(url="https://optimaquality.es", description="Production")
 */
class ApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/answers/today/carried",
     *      summary="Show stadistics",
     *      @OA\Response(
     *          response=200,
     *          description="Show stadistics for today",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(type="boolean")
     *              },
     *              @OA\Examples(example="result", value={"finish": 0, "porcentatge": -100, "total": 0, "complete": -100, "cancelled": 0, "cancelled_yesterday": 0}, summary="Example")
     *          )
     *       ),
     *      @OA\Response(
     *          response="default",
     *          description="Error"
     *      )
     * )
     */
    public function survey_carried_today() {
        $finish_today = count(Answer::whereIn('status',[2,4,5])->where('updated_at','=',date('Y-m-d'))->get());
        $finish_yesterday = count(Answer::whereIn('status',[2,4,5])->where('updated_at','=',date('Y-m-d',strtotime("-1 days")))->get());
        if($finish_yesterday!=0) {
            $porcentaje_finalizadas = number_format(($finish_today/$finish_yesterday)*100-100,2);
        } else {
            $porcentaje_finalizadas = -100;
        }

        $response['finish'] = $finish_today;
        $response['porcentage'] = $porcentaje_finalizadas;

        $total_today = count(Answer::where('expiration','=',date('Y-m-d'))->where('status','<>','8')->get());
        if($total_today!=0) {
            $ftoday = count(Answer::whereIn('status',[2,4,5])->where('expiration','=',date('Y-m-d'))->get());
            $porcentaje_dia = number_format(($ftoday/$total_today)*100,2);
        } else {
            $porcentaje_dia = -100;
        }

        $response['total'] = $total_today;
        $response['complete'] = $porcentaje_dia;

        $total_cancelled = count(Answer::where('updated_at','=',date('Y-m-d'))->where('status','=','8')->get());
        $total_cancelled_yesterday = count(Answer::where('status','=','8')->where('updated_at','=',date('Y-m-d',strtotime("-1 days")))->get());

        $response['cancelled'] = $total_cancelled;
        $response['cancelled_yesterday'] = $total_cancelled_yesterday;

        return response()->json($response);
    }

    /**
     * @OA\Get(
     *      path="/api/answers/month/carried",
     *      summary="Show stadistics",
     *      @OA\Response(
     *          response=200,
     *          description="Show stadistics for month",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(type="boolean")
     *              },
     *              @OA\Examples(example="result", value={"finish": 0, "porcentatge": -100, "total": 0, "complete": -100, "cancelled": 0, "cancelled_yesterday": 0}, summary="Example")
     *          )
     *       ),
     *      @OA\Response(
     *          response="default",
     *          description="Error"
     *      )
     * )
     */
    public function survey_carried_month() {
        $first_month = $this->first_month_day(0);
        $last_month = $this->last_month_day(0);
        $first_month_pre = $this->first_month_day(1);
        $last_month_pre = $this->last_month_day(1);

        $finish_today = count(Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$first_month,$last_month])->get());
        $finish_yesterday = count(Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$first_month_pre,$last_month_pre])->get());
        $porcentaje_finalizadas = number_format(($finish_today/$finish_yesterday)*100-100,2);

        $response['finish'] = $finish_today;
        $response['porcentage'] = $porcentaje_finalizadas;

        $ftoday = count(Answer::whereIn('status',[2,4,5])->whereBetween('expiration',[$first_month,$last_month])->get());

        $total_today = count(Answer::whereBetween('expiration',[$first_month,$last_month])->where('status','<>','8')->get());
        $porcentaje_dia = number_format(($ftoday/$total_today)*100,2);

        $response['total'] = $total_today;
        $response['complete'] = $porcentaje_dia;

        $total_cancelled = count(Answer::whereBetween('updated_at',[$first_month,$last_month])->where('status','=','8')->get());
        $total_cancelled_yesterday = count(Answer::where('status','=','8')->whereBetween('updated_at',[$first_month_pre,$last_month_pre])->get());

        $response['cancelled'] = $total_cancelled;
        $response['cancelled_yesterday'] = $total_cancelled_yesterday;

        return response()->json($response);
    }

    public function answer_type() {
        $first_month = $this->first_month_day(0);
        $last_month = $this->last_month_day(0);
        $first_month_pre = $this->first_month_day(1);
        $last_month_pre = $this->last_month_day(1);

        $response['open'] = count(Answer::where('status','=','0')->whereBetween('updated_at',[$first_month,$last_month])->get());
        $response['assigned'] = count(Answer::where('status','=','1')->whereBetween('updated_at',[$first_month,$last_month])->get());
        $response['qc'] = count(Answer::where('status','=','2')->whereBetween('updated_at',[$first_month,$last_month])->get());
        $response['send'] = count(Answer::where('status','=','3')->whereBetween('updated_at',[$first_month,$last_month])->get());
        $response['review'] = count(Answer::where('status','=','4')->whereBetween('updated_at',[$first_month,$last_month])->get());
        $response['complete'] = count(Answer::where('status','=','5')->whereBetween('updated_at',[$first_month,$last_month])->get());
        $response['cancel'] = count(Answer::where('status','=','8')->whereBetween('updated_at',[$first_month,$last_month])->get());
        
        return response()->json($response);
    }

    public function answered() {
        $response = count(Answer::where('status','=','4')->get());

        return response()->json($response);
    }

    public function window(Request $request) {

        if($request->diff!='') {
            $diff = $request->diff;
        } else {
            $diff = 0;
        }

        if($request->monthly==true) {
            $monday = $this->first_month_day($diff);
            $suneday = $this->last_month_day($diff);
            
            $old_monday = $this->first_month_day($diff+1);
            $old_suneday = $this->last_month_day($diff+1);
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

    public function evolution() {
        $month = date('m');
        $time = [];
        $teams = [];

        for($i=1;$i<=9;$i++) {
            $agents = Agent::where('team','LIKE','%'.$i.'%')->get();
            $id = [];
            foreach($agents as $agent) {
                $id[] = $agent->id;
            }
            $tasks = Task::whereIn('owner',$id)->get();
            
            $id = [];
            foreach($tasks as $task) {
                if($task->answer_id != '') $id[] = $task->answer_id;
            }
            $teams[] = $id;
        }

        for($i=1; $i<=12; $i++) {
            $year = date('Y');
            $lastday = date('Y-m-t', mktime(0,0,0, $month-$i, 1, $year));
            $firstday = date('Y-m-d', mktime(0,0,0, $month-$i, 1, $year));
            $actual_month = date('M',mktime(0,0,0, $month-$i, 1, $year));

            $time[$actual_month] = [];
            
            foreach($teams as $key => $team) {
                $name = 'eq'.$key+1;
                
                $all_answers = Answer::whereIn('status',[2,4,5])->whereBetween('expiration',[$firstday,$lastday])->whereIn('id',$team)->get();
                $arr['results'] = $this->media($all_answers);
                
                $time[$actual_month][$name] = $arr;
            }
            $all_answers = Answer::whereIn('status',[2,4,5])->whereBetween('expiration',[$firstday,$lastday])->get();
            $arr['results'] = $this->media($all_answers);

            $time[$actual_month]['general'] = $arr;
        }
        return response()->json($time);
    }

    public function leaderboard(Request $request) {
        $type = ($request->type != null) ? $request->type : 'agent';

        $first = $request->init;
        $last = $request->finish;

        $results = DB::select('SELECT answers.answer, tasks.owner FROM answers, tasks WHERE answers.id = tasks.answer_id AND answers.status IN (2,4,5) AND answers.expiration BETWEEN :first AND :last', [
            'first' => $first,
            'last' => $last
        ]);
        $prepare = [];
        foreach($results as $result) {
            if($type=='agent') {
                $prepare[$result->owner][] = $result->answer;
            } else if($type=='teams') {
                $agent = Agent::find($result->owner);
                $prepare[$agent->team][] = $result->answer;
            } else {
                $prepare['general'][]=$result->answer;
            }
        }
        $res = [];
        foreach($prepare as $key => $pre) {
            $res[$key] = $this->media($pre,false);
            if($request->type=='agent') {
                $res[$key]['agent'] = Agent::find($key);
            } else if($request->type=='teams') {
                $res[$key]['team'] = $key;
            }
        }
        if(count($res)!=0) {
            foreach($res as $key => $values) {
                $order1[$key] = $values[0];
                $order2[$key] = $values['total'];
            }
            array_multisort($order1, SORT_DESC, $order2, SORT_DESC, $res);
            return response()->json($res);
        }
        return response()->json(0);
    }

    private function media($answers,$object=true) {
        $question = [];
        $question[0] = 0;
        $question[1] = 0;
        $question[2] = 0;
        $question[3] = 0;

        $sum = 0;

        foreach($answers as $answer) {
            if($object) {
                $res = json_decode($answer->answer);
            } else {
                $res = json_decode($answer);
            }
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
