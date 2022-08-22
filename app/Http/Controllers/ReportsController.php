<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function leaderboardAgents() {

        $first = $this->first_month_day();
        $last = $this->last_month_day();

        $results = DB::select('SELECT answers.answer, tasks.owner FROM answers, tasks WHERE answers.id = tasks.answer_id AND answers.status IN (2,4,5) AND answers.expiration BETWEEN :first AND :last', [
            'first' => $first,
            'last' => $last
        ]);
        $prepare = [];
        foreach($results as $result) {
            $prepare[$result->owner][] = $result->answer;
        }
        $res = [];
        foreach($prepare as $key => $pre) {
            $res[$key] = $this->media($pre);
            $res[$key]['agent'] = Agent::find($key);
        }

        foreach($res as $key => $values) {
            $order1[$key] = $values[0];
            $order2[$key] = $values['total'];
        }

        array_multisort($order1, SORT_DESC, $order2, SORT_DESC, $res);


        return view('admin.reports.leaderboard_agents', ['leaderboard' => $res]);
    }

    private function last_month_day() { 
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month, 0, $year));
        $day = $day;
        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }

    private function first_month_day() {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }

    private function media($answers) {
        $question = [];
        $question[0] = 0;
        $question[1] = 0;
        $question[2] = 0;
        $question[3] = 0;

        $sum = 0;

        foreach($answers as $answer) {
            $res = json_decode($answer);
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
}
