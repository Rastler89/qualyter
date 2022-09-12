<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function leaderboardAgents() {
        $first = first_month_day();
        $last = last_month_day();
        return view('admin.reports.leaderboard', ['first' => $first, 'last' => $last]);
    }
    
    public function leaderboard_animated() {
        $first = first_month_day();
        $last = last_month_day();
        $results = DB::select('SELECT tasks.owner FROM answers, tasks WHERE answers.id = tasks.answer_id AND answers.status IN (2,4,5) AND answers.expiration BETWEEN :first AND :last GROUP BY tasks.owner', [
            'first' => $first,
            'last' => $last
        ]);
        $agents = Agent::where('active','=','1')->get();//whereIn('id',json_decode(json_encode ( $results ) , true))->get();
        return view('admin.reports.leaderboard_animated', ['first' => $first, 'last' => $last, 'agents' => $agents]);
    }

    public function targets() {
        $first = first_month_day();
        $last = last_month_day();
        return view('admin.reports.targets', ['first' => $first, 'last' => $last]);
    }

    public function incidences() {
        $first = first_month_day();
        $last = last_month_day();
        return view('admin.reports.incidences', ['first' => $first, 'last' => $last]);
    }
    
}
