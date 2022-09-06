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
        return view('admin.reports.leaderboard', ['first' => $first, 'last' => $last]);
    }
    
    public function leaderboard_animated() {
        $first = '2022-08-01';//$this->first_month_day();
        $last = '2022-08-31';//$this->last_month_day();
        $results = DB::select('SELECT tasks.owner FROM answers, tasks WHERE answers.id = tasks.answer_id AND answers.status IN (2,4,5) AND answers.expiration BETWEEN :first AND :last GROUP BY tasks.owner', [
            'first' => $first,
            'last' => $last
        ]);
        $agents = Agent::whereIn('id',json_decode(json_encode ( $results ) , true))->get();//where('active','=','1')->get();
        return view('admin.reports.leaderboard_animated', ['first' => $first, 'last' => $last, 'agents' => $agents]);
    }

    public function teams() {
        $first = $this->first_month_day();
        $last  = $this->last_month_day();
        return view('admin.reports.teams', ['first' => $first, 'last' => $last]);
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

    
}
