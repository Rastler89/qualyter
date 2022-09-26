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
