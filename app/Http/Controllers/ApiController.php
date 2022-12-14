<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Agent;
use App\Models\Task;
use App\Models\Incidence;
use App\Models\Store;
use App\Models\Congratulation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \Debugbar;
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
        $finish_today = count(Answer::whereIn('status',[2,4,5])->where('updated_at','like', '%'.date('Y-m-d').'%')->get());
        $finish_yesterday = count(Answer::whereIn('status',[2,4,5])->where('updated_at','like', '%'.date('Y-m-d',strtotime("-1 days")).'%')->get());
        if($finish_yesterday!=0) {
            $porcentaje_finalizadas = number_format(($finish_today/$finish_yesterday)*100-100,2);
        } else {
            $porcentaje_finalizadas = -100;
        }

        $response['finish'] = $finish_today;
        $response['porcentage'] = $porcentaje_finalizadas;

        $total_today = count(Answer::where('updated_at','like','%'.date('Y-m-d').'%')->where('status','<>','8')->get());
        if($total_today!=0) {
            $ftoday = count(Answer::whereIn('status',[2,4,5])->where('updated_at','like','%'.date('Y-m-d').'%')->get());
            $porcentaje_dia = number_format(($ftoday/$total_today)*100,2);
        } else {
            $porcentaje_dia = -100;
        }

        $response['total'] = $total_today;
        $response['complete'] = $porcentaje_dia;

        /*$total_cancelled = count(Answer::where('updated_at','like','%'.date('Y-m-d').'%')->where('status','=','8')->get());
        $total_cancelled_yesterday = count(Answer::where('status','=','8')->where('updated_at','like','%'.date('Y-m-d',strtotime("-1 days")).'%')->get());

        $response['cancelled'] = $total_cancelled;
        $response['cancelled_yesterday'] = $total_cancelled_yesterday;*/

        $total_incidence = count(Incidence::where('created_at','like','%'.date('Y-m-d').'%')->get());
        $total_incidence_yesterday = count(Incidence::where('created_at','like','%'.date('Y-m-d').'%')->get());

        $response['incidence'] = $total_incidence;
        $response['incidence_yesterday'] =  $total_incidence_yesterday;

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
        $first_month = $this->first_month_day_api(0);
        $last_month = $this->last_month_day_api(0);
        $first_month_pre = $this->first_month_day_api(1);
        $last_month_pre = $this->last_month_day_api(1);

        $finish_today = count(Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$first_month,$last_month])->get());
        $finish_yesterday = count(Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$first_month_pre,$last_month_pre])->get());
        $porcentaje_finalizadas = number_format(($finish_today/$finish_yesterday)*100-100,2);

        $response['finish'] = $finish_today;
        $response['porcentage'] = $porcentaje_finalizadas;

        $ftoday = count(Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$first_month,$last_month])->get());

        $total_today = count(Answer::whereBetween('updated_at',[$first_month,$last_month])->where('status','<>','8')->get());
        $porcentaje_dia = number_format(($ftoday/$total_today)*100,2);

        $response['total'] = $total_today;
        $response['complete'] = $porcentaje_dia;

        /*$total_cancelled = count(Answer::whereBetween('updated_at',[$first_month,$last_month])->where('status','=','8')->get());
        $total_cancelled_yesterday = count(Answer::where('status','=','8')->whereBetween('updated_at',[$first_month_pre,$last_month_pre])->get());

        $response['cancelled'] = $total_cancelled;
        $response['cancelled_yesterday'] = $total_cancelled_yesterday;*/

        $total_incidence = count(Incidence::whereBetween('created_at',[$first_month,$last_month])->get());
        $total_incidence_yesterday = count(Incidence::whereBetween('created_at',[$first_month_pre,$last_month_pre])->get());

        $response['incidence'] = $total_incidence;
        $response['incidence_yesterday'] =  $total_incidence_yesterday;

        return response()->json($response);
    }

    public function answer_type() {
        $first_month = $this->first_month_day_api(0);
        $last_month = $this->last_month_day_api(0);
        $first_month_pre = $this->first_month_day_api(1);
        $last_month_pre = $this->last_month_day_api(1);

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
        $answers = DB::select('SELECT count(answers.id) as total, users.name from answers, users where answers.user = users.id and answers.status = 4 group by answers.user');
        $response['full'] = count(Answer::where('status','=','4')->get());
        $response['data'] = $answers;

        return response()->json($response);
    }

    public function window(Request $request) {

        if($request->diff!='') {
            $diff = $request->diff;
        } else {
            $diff = 0;
        }

        if($request->monthly==true) {
            $monday = $this->first_month_day_api($diff);
            $suneday = $this->last_month_day_api($diff);
            
            $old_monday = $this->first_month_day_api($diff+1);
            $old_suneday = $this->last_month_day_api($diff+1);
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

            $answers = Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$monday,$suneday])->whereIn('id',$id)->get();
    
            $results = $this->media($answers);
    
            $old_answers = Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$old_monday,$old_suneday])->whereIn('id',$id)->get();
    
            $old_results = $this->media($old_answers);
    
            $team['new'] = $results;
            $team['old'] = $old_results;

            $response[$i] = $team;

        }
        $all_answers = Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$monday,$suneday])->get();
        $all_results = $this->media($all_answers);
        $all_old_answers = Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$old_monday,$old_suneday])->get();
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
                
                $all_answers = Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$firstday,$lastday])->whereIn('id',$team)->get();
                $arr['results'] = $this->media($all_answers);
                
                $time[$actual_month][$name] = $arr;
            }
            $all_answers = Answer::whereIn('status',[2,4,5])->whereBetween('updated_at',[$firstday,$lastday])->get();
            $arr['results'] = $this->media($all_answers);

            $time[$actual_month]['general'] = $arr;
        }
        return response()->json($time);
    }

    public function leaderboard(Request $request) {
        $type = ($request->type != null) ? $request->type : 'agent';

        $first = $request->init;
        $last = $request->finish;

        $results = DB::select('SELECT answers.answer, tasks.owner, answers.id, tasks.priority FROM answers, tasks WHERE answers.id = tasks.answer_id AND answers.status IN (2,4,5) AND answers.created_at BETWEEN :first AND :last', [
            'first' => $first,
            'last' => $last
        ]);
        $calc = DB::select('SELECT COUNT(answers.id) as total FROM answers WHERE answers.status IN (2,4,5) AND answers.created_at BETWEEN :first AND :last', [
            'first' => $first,
            'last' => $last
        ]);
        $total = $calc[0]->total;
        $prepare = [];
        $extra = [];
        $general = [];
        $arr = [];
        $id = []; 
        foreach($results as $result) {
            $arr['answer'] = $result->answer;
            $arr['type'] = $result->priority;
            if($type=='agent') {
                $agent = Agent::find($result->owner);
                if($agent->active==1) {
                    $prepare[$result->owner][] = $arr;
                    $cong = Congratulation::whereBetween('created_at',[$first,$last])->where('agent','=',$result->owner)->get();
                    $inc = count(Incidence::whereBetween('created_at',[$first,$last])->where('owner','=',$result->owner)->get());
                    $extra[$result->owner] = $cong->sum('weight') - $inc;
                }
            } else if($type=='teams') {
                $agent = Agent::find($result->owner);
                $id[$agent->team][] = $agent->id;
                $prepare[$agent->team][] = $arr;
            } else {
                $string = $result->owner.' - '.$result->id;
                if(!in_array($string,$general)) {
                    $general[] = $string;
                    $prepare['general'][]=$arr;
                }
            }
        }
        if($type=='teams') {
            foreach($id as $key => $i) {
                $cong = Congratulation::whereBetween('created_at',[$first,$last])->whereIn('agent',$i)->get();  
                $inc = count(Incidence::whereBetween('created_at',[$first,$last])->whereIn('owner',$i)->get());
                $extra[$key] = $cong->sum('weight') - $inc;
            }
        } else if($type!='agent') {
            $cong = Congratulation::whereBetween('created_at',[$first,$last])->get();
            $inc = count(Incidence::whereBetween('created_at',[$first,$last])->get());
            $extra['general'] = $cong->sum('weight') - $inc;
        }
        $res = [];
        
        foreach($prepare as $key => $pre) {
            $res[$key] = $this->media($pre,false,$request->leaderboard,intval($request->visit));
            if($request->type=='agent') {
                $res[$key]['agent'] = Agent::find($key);
            } else if($request->type=='teams') {
                $res[$key]['team'] = $key;
            }
        }
        if(count($res)!=0) {
            foreach($res as $key => $values) {
                $percentatge = $values['total']/$total;
                $points = $percentatge*0.75+$values[0]*0.025+($extra[$key]*0.03)/10;
                $order1[$key] = $points;
                $res[$key]['points'] = number_format($points*10,2);
            }
            array_multisort($order1, SORT_DESC, $res);
            if($type=='general') $res['general']['total'] = $total;
            return response()->json($res);
        }
        return response()->json(0);
    }

    public function targets(Request $request) {
        $type = ($request->type != null) ? $request->type : 'agent';

        $first = $request->init;
        $last = $request->finish;

        $visits = 0;
        $qc = 0;
        $send = 0;
        $resp = 0;

        $ots = Task::whereBetween('expiration',[$first.' 00:00:00',$last.' 23:59:59'])->where('answer_id','<>',null)->get();        

        $prepare=[];
        switch($type) {
            case 'agent':
                foreach($ots as $ot) {
                    $agent = Agent::find($ot->owner);
                    $prepare[$ot->owner]['targets'][] = $ot->answer_id;
                    $prepare[$ot->owner]['agent'] = $agent;
                }
                break;
            case 'teams':
                foreach($ots as $ot) {
                    $agent = Agent::find($ot->owner);
                    $prepare[$agent->team]['targets'][] = $ot->answer_id;
                    $prepare[$agent->team]['team'] = $agent->team;
                }
                break;

            case 'general':

                $answers = DB::select('SELECT id FROM answers WHERE answers.created_at BETWEEN :first AND :last', [
                    'first' => $first,
                    'last' => $last
                ]);

                foreach($answers as $ot) {
                    $prepare['all'][] = $ot->id;
                }

                $res['general']['targets'] = $this->information($prepare['all']);
                return response()->json($res);
                break;
        }

        foreach($prepare as &$item) {
            $item['targets'] = $this->information($item['targets']);
        }

        return response()->json($prepare);
    }

    public function incidences(Request $request) {
        $type = ($request->type != null) ? $request->type : 'agent';

        $first = $request->init;
        $last = $request->finish;

        $incidences = Incidence::whereBetween('created_at',[$first,$last])->get();
        $prepare = [];
        if($type=='general') {
            $prepare['general']['incidences']=$this->information_incidence($incidences,$first,$last,true);

            return response()->json($prepare);
        } else {
            foreach($incidences as $incidence) {
                $agent = Agent::find($incidence->owner);
                if($type=='agent') {
                    $prepare[$incidence->owner]['incidences'][] = $incidence;
                    $prepare[$incidence->owner]['agent']=$agent;
                } else {
                    $prepare[$agent->team]['incidences'][] = $incidence;
                    $prepare[$agent->team]['team']=$agent->team;
                }
            }
        }

        foreach($prepare as &$item) {
            $item['incidences'] = $this->information_incidence($item['incidences'],$first,$last);
        }

        return response()->json($prepare);
    }

    public function congratulations(Request $request) {
        $type = ($request->type != null) ? $request->type : 'agent';

        $first = $request->init;
        $last = $request->finish;

        $congratulations = Congratulation::whereBetween('created_at',[$first,$last])->get();
        $prepare = [];
        if($type=='general') {
            if($first==$last) {
                $ots = Task::whereBetween('expiration',[$first.' 00:00:01',$last.' 23:59:59'])->where('answer_id','<>',null)->get();  
            } else {
                $ots = Task::whereBetween('expiration',[$first,$last])->where('answer_id','<>',null)->get();
            }

            $id=[];
            foreach($ots as $ot) {
                array_push($id,$ot->answer_id);
            }    
            $prepare['general']['visits'] = count(Answer::whereIn('id',$id)->where('status','<>',8)->get());  
    

            $prepare['general']['total'] = count($congratulations);
            $prepare['general']['percentage'] = number_format(($prepare['general']['total']/$prepare['general']['visits'])*100,2);


            return response()->json($prepare);
        } else {
            foreach($congratulations as $congratulation) {
                $agent = Agent::find($congratulation->agent);
                if($type=='agent') {
                    $prepare[$congratulation->agent]['congratulation'][] = $congratulation;
                    $prepare[$congratulation->agent]['agent']=$agent;
                } else {
                    $prepare[$agent->team]['congratulation'][] = $congratulation;
                    $prepare[$agent->team]['team']=$agent->team;         
                }
            }
        }
        foreach($prepare as $key => $line) {
            $clave = $key;
            if($type!='agent') {
                $key = DB::select('SELECT agents.id FROM agents where team = :team',[
                    'team' => $key
                ]);
            }
            if($first==$last) {
                $ots = Task::whereBetween('expiration',[$first.' 00:00:01',$last.' 23:59:59'])->where('answer_id','<>',null)->get();  
            } else {
                $ots = Task::whereBetween('expiration',[$first,$last])->where('answer_id','<>',null)->get();
            }
            $id=[];
            foreach($ots as $ot) {
                array_push($id,$ot->answer_id);
            }    
            $prepare[$clave]['visits'] = count(Answer::whereIn('id',$id)->where('status','<>',8)->get());  
            $prepare[$clave]['total'] = count($line['congratulation']);
            if($type=='teams') {
                $prepare[$clave]['percentage'] = number_format(($prepare[$clave]['total']/$prepare[$clave]['visits'])*100,2);
            } else {
                $prepare[$clave]['percentage'] = number_format(($prepare[$key]['total']/$prepare[$key]['visits'])*100,2);
            }
        }
        return response()->json($prepare);
    }

    public function incidence_control_today() {
        $incidences = Incidence::where('closed','like','%'.date('Y-m-d').'%')->get();

        foreach($incidences as &$incidence) {
            $store = Store::where('code','=',$incidence->store)->first();
            $incidence->store_name = $store->name;
            $user = User::find($incidence->responsable);
            $incidence->responsable = $user->name;
        }

        return response()->json($incidences);
    }

    public function answers_waiting() {
        if(date("D")=="Mon") {
            $week_start = date("Y-m-d 00:00:00");
        } else {
            $week_start = date("Y-m-d 00:00:00",strtotime('last Monday', time()));
        }
        
        $week_end = date("Y-m-d 23:59:59",strtotime('next Sunday',time()));

        $total = count(Answer::whereBetween('created_at',[$week_start,$week_end])->where('status','=','3')->get());


        return response()->json($total);
    }

    /**
     * 
     * PRIVATE FUNCTIONS (ONLY)
     * 
     */
    private function information_incidence($incidences,$first,$last,$general=false) {
        $answers = 0;
        $id = [];

        foreach($incidences as $incidence) {
            $agent = Agent::find($incidence->owner);
            array_push($id,$agent->id);
        }
        $id = array_unique($id);
        
        if($general!==true) {
            if($first==$last) {
                $ots = Task::whereBetween('expiration',[$first.' 00:00:01',$last.' 23:59:59'])->where('answer_id','<>',null)->whereIn('owner',$id)->get();  
            } else {
                $ots = Task::whereBetween('expiration',[$first,$last])->where('answer_id','<>',null)->whereIn('owner',$id)->get();
            }
        } else {
            if($first==$last) {
                $ots = Task::whereBetween('expiration',[$first.' 00:00:01',$last.' 23:59:59'])->where('answer_id','<>',null)->get();  
            } else {
                $ots = Task::whereBetween('expiration',[$first,$last])->where('answer_id','<>',null)->get();
            }
        }
        $id=[];
        foreach($ots as $ot) {
            array_push($id,$ot->answer_id);
        }    
        $answers = count(Answer::whereIn('id',$id)->where('status','<>',8)->get());  

        $num_incidences = count($incidences);
        $per_incidences = number_format(($num_incidences/$answers)*100,2);

        $count = 0;
        $urgent = 0;
        $high = 0;
        $medium = 0;
        $low = 0;
        $time_total = 0;

        foreach($incidences as $incidence) {
            if($incidence->status==4) {
                $count += 1;
                $time_total += timeLive($incidence);
            }
            switch($incidence->impact) {
                case 0: 
                    case 0: 
                case 0: 
                    $urgent = $urgent+1;
                    break;
                case 1:
                    $high = $high+1;
                    break;
                case 2:
                    $medium = $medium+1;
                    break;
                case 3:
                    $low = $low+1;
                    break;
            }
        }

        $per_completed = number_format(($count/$num_incidences)*100,2);
        $per_urgent = number_format(($urgent/$num_incidences)*100,2);
        $per_high = number_format(($high/$num_incidences)*100,2);
        $per_medium = number_format(($medium/$num_incidences)*100,2);
        $per_low = number_format(($low/$num_incidences)*100,2);
        $time_average = $time_total / $num_incidences;

        $body = [
            'per_incidences' => $per_incidences,
            'num_incidences' => $num_incidences,
            'per_completed'  => $per_completed,
            'average_time'   => calcMinutes($time_average),
            'per_urgent'      => $per_urgent,
            'per_high'       => $per_high,
            'per_medium'     => $per_medium,
            'per_low'        => $per_low
        ];

        return $body;
    }

    private function information($id) {
        $answers = Answer::whereIn('id',$id)->where('status','<>','8')->get();
        $visits = (int)count($answers);

        $answers = Answer::whereIn('id',$id)->where('status','=','1')->get();
        $not_emails = 0;
        foreach($answers as $answer) {
            $store = Store::where('code','=',$answer->store)->first();
            if($store->email==null || $store->email=='' || $store->email == '-') {
                $not_emails = $not_emails + 1;
            }
        }
    
        $answers = Answer::whereIn('id',$id)->whereIn('status',[2,3,4,5])->get();
        $contacts = (int)count($answers);

        $answers = Answer::whereIn('id',$id)->where('status','=','2')->get();
        $qc = (int)count($answers);
    
        $answers = Answer::whereIn('id',$id)->whereIn('status',[3,4,5])->get();
        $send = (int)count($answers);
    
        $answers = Answer::whereIn('id',$id)->whereIn('status',[4,5])->get();
        $resp = (int)count($answers);
    
        $answers = Answer::whereIn('id',$id)->whereIn('status',[2,4,5])->get();
        $answered = (int)count($answers);

        if($contacts==0) {
            $per_ans = 0;
            $tot_ans = 0;
            $per_con = 0;
        } else {
            $per_con = number_format(($contacts/$visits)*100,2);
            $per_ans = number_format(($answered/$contacts)*100,2);
            $tot_ans = number_format(($answered/$visits)*100,2);
        }
    
        $body = [
            'visits' => $visits,
            'not_emails' => $not_emails,
            'qc' => $qc,
            'send' => $send,
            'resp' => $resp,
            'per_con' => $per_con,
            'per_ans' => $per_ans,
            'tot_ans' => $tot_ans
        ];

        return $body;
    }

    private function media($answers,$object=true,$leaderboard=false,$visit=0) {
        if($leaderboard=='false') {
            $leaderboard = false;
        } else {
            $leaderboard = true;
        }
        $question = [];
        $question[0] = 0;
        $question[1] = 0;
        $question[2] = 0;
        $question[3] = 0;

        $sum = 0;

        foreach($answers as $key => $answer) {
            if($object) {
                $res = json_decode($answer->answer);
            } else {
                $res = json_decode($answer['answer']);
            }
            $answer['type'] = ($leaderboard) ? $answer['type'] : 'none';
            
            if(($visit==0 && $answer['type']!='PREVENTIVO') || ($visit==1 && $answer['type']=='PREVENTIVO')) {
                $question[0]+=$res->valoration[0];
                $question[1]+=$res->valoration[1];
                $question[2]+=$res->valoration[2];
                $question[3]+=$res->valoration[3];
            
                $sum++;
            }
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
                $answers->whereBetween('updated_at',[$body['start_date'],$body['end_date']]);
            } else {
                //hasta fecha actual
                $answers->where('updated_at','<=',$body['start_date']);
            }
        } else {
            if($body['end_date'] != null) {
                //tenemos fecha final
                $answers->where('updated_at','>=',$body['end_date']);
            }
        }

        return $answers;
    }

    private function last_month_day_api($diff) { 
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month, 0, $year));
        $day = ($diff==0) ? $day+1 : $day;
        return date('Y-m-d', mktime(0,0,0, $month-$diff, $day, $year));
    }

    /** Actual month first day **/
    private function first_month_day_api($diff) {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month-$diff, 1, $year));
    }

}
