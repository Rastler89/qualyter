<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Agent;
use App\Models\Task;
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
        $finish_today = count(Answer::whereIn('status',[2,4,5])->where('expiration','=',date('Y-m-d'))->get());
        $finish_yesterday = count(Answer::whereIn('status',[2,4,5])->where('expiration','=',date('Y-m-d',strtotime("-1 days")))->get());
        if($finish_yesterday!=0) {
            $porcentaje_finalizadas = number_format(($finish_today/$finish_yesterday)*100-100,2);
        } else {
            $porcentaje_finalizadas = -100;
        }

        $response['finish'] = $finish_today;
        $response['porcentage'] = $porcentaje_finalizadas;

        $total_today = count(Answer::where('expiration','=',date('Y-m-d'))->where('status','<>','8')->get());
        if($total_today!=0) {
            $porcentaje_dia = number_format(($finish_today/$total_today)*100,2);
        } else {
            $porcentaje_dia = -100;
        }

        $response['total'] = $total_today;
        $response['complete'] = $porcentaje_dia;

        $total_cancelled = count(Answer::where('expiration','=',date('Y-m-d'))->where('status','=','8')->get());
        $total_cancelled_yesterday = count(Answer::where('status','=','8')->where('expiration','=',date('Y-m-d',strtotime("-1 days")))->get());

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

        $finish_today = count(Answer::whereIn('status',[2,4,5])->whereBetween('expiration',[$first_month,$last_month])->get());
        $finish_yesterday = count(Answer::whereIn('status',[2,4,5])->whereBetween('expiration',[$first_month_pre,$last_month_pre])->get());
        $porcentaje_finalizadas = number_format(($finish_today/$finish_yesterday)*100-100,2);

        $response['finish'] = $finish_today;
        $response['porcentage'] = $porcentaje_finalizadas;

        $total_today = count(Answer::whereBetween('expiration',[$first_month,$last_month])->where('status','<>','8')->get());
        $porcentaje_dia = number_format(($finish_today/$total_today)*100,2);

        $response['total'] = $total_today;
        $response['complete'] = $porcentaje_dia;

        $total_cancelled = count(Answer::whereBetween('expiration',[$first_month,$last_month])->where('status','=','8')->get());
        $total_cancelled_yesterday = count(Answer::where('status','=','8')->whereBetween('expiration',[$first_month_pre,$last_month_pre])->get());

        $response['cancelled'] = $total_cancelled;
        $response['cancelled_yesterday'] = $total_cancelled_yesterday;

        return response()->json($response);
    }

    public function answer_type() {
        $first_month = $this->first_month_day(0);
        $last_month = $this->last_month_day(0);
        $first_month_pre = $this->first_month_day(1);
        $last_month_pre = $this->last_month_day(1);

        $response['open'] = count(Answer::where('status','=','0')->whereBetween('expiration',[$first_month,$last_month])->get());
        $response['assigned'] = count(Answer::where('status','=','1')->whereBetween('expiration',[$first_month,$last_month])->get());
        $response['qc'] = count(Answer::where('status','=','2')->whereBetween('expiration',[$first_month,$last_month])->get());
        $response['send'] = count(Answer::where('status','=','3')->whereBetween('expiration',[$first_month,$last_month])->get());
        $response['review'] = count(Answer::where('status','=','4')->whereBetween('expiration',[$first_month,$last_month])->get());
        $response['complete'] = count(Answer::where('status','=','5')->whereBetween('expiration',[$first_month,$last_month])->get());
        $response['cancel'] = count(Answer::where('status','=','8')->whereBetween('expiration',[$first_month,$last_month])->get());
        
        return response()->json($response);
    }

    public function window(Request $request) {
        $body = json_decode($request->getContent(), true);

        if($request->diff!='') {
            $diff = $request->diff;
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
